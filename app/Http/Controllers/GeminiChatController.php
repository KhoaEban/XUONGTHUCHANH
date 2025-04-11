<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GeminiChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $user = Auth::user();
        $name = $user->name ?? 'bạn';
        $userMessage = $request->input('message');

        // Lưu tin nhắn của người dùng vào database
        if (Auth::check()) {
            ChatMessage::create([
                'user_id' => $user->id,
                'message' => $userMessage,
                'is_user' => true,
            ]);
        }

        $prompt = <<<PROMPT
        Bạn là một người trợ lý ảo thông minh, có khả năng phân tích câu hỏi và trả lời một cách tự nhiên.
        Phân tích câu sau và CHỈ trả về JSON đúng định dạng: { "intent": "..." }.
        Không thêm giải thích hoặc ký tự thừa.
        Các intent hợp lệ gồm: 'course_count', 'category_count', 'lesson_count', 'list_courses', 'explain_lesson', 'other'.
        Câu: "$userMessage"
        PROMPT;

        $aiIntentResponse = $this->queryGemini($prompt);
        $intent = $this->extractIntent($aiIntentResponse);

        if (!Auth::check() && $intent !== 'other') {
            return $this->reply("Bạn cần đăng nhập để sử dụng chatbot.", $name, false);
        }
        $intentHandlers = [
            'course_count' => fn() => $this->reply("Hiện tại, chúng tôi có " . Course::count() . " khóa học.", $name, false),
            'category_count' => fn() => $this->reply("Hiện tại, chúng tôi có " . Category::count() . " danh mục.", $name, false),
            'lesson_count' => fn() => $this->reply("Hiện tại, chúng tôi có " . Lesson::count() . " bài học.", $name, false),
            'list_courses' => fn() => $this->listCourses($name),
            'explain_lesson' => fn() => $this->explainLesson($userMessage, $name),
            'other' => fn() => $this->chatWithGemini($userMessage, $name)
        ];

        return ($intentHandlers[$intent] ?? $intentHandlers['other'])();
    }


    private function reply(string $message, string $name, bool $isUser = false)
    {
        if (Auth::check() && !$isUser) {
            Auth::user()->chatMessages()->create([
                'message' => $message,
                'is_user' => false,
            ]);
        }
        return response()->json(['reply' => "Chào $name! $message"]);
    }

    private function listCourses($name)
    {
        $courses = Course::select('title')->take(10)->get();
        if ($courses->isEmpty()) {
            return $this->reply("Hiện tại chưa có khóa học nào.", $name, false);
        }

        $response = "Các khóa học hiện có:\n";
        foreach ($courses as $index => $course) {
            $response .= ($index + 1) . ". {$course->title}\n";
        }

        return $this->reply($response, $name, false);
    }

    private function chatWithGemini(string $message, string $name)
    {
        if (!Auth::check()) {
            return $this->reply("Bạn cần đăng nhập để sử dụng đầy đủ chức năng của chatbot.", $name, false);
        }

        $response = $this->queryGemini($message);
        $reply = $this->extractText($response) ?? 'Xin lỗi, tôi chưa hiểu câu hỏi của bạn.';

        return $this->reply($reply, $name, false);
    }

    private function queryGemini(string $prompt)
    {
        return Http::post(env('GEMINI_API_URL') . '?key=' . env('GEMINI_API_KEY'), [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ])->json();
    }

    private function extractIntent($aiResponse): string
    {
        $text = $this->extractText($aiResponse);
        preg_match('/\{.*?\}/s', $text, $matches);
        if (!empty($matches[0])) {
            $json = json_decode($matches[0], true);
            if (json_last_error() === JSON_ERROR_NONE && isset($json['intent'])) {
                return $json['intent'];
            }
        }
        return 'other';
    }

    private function extractText($data): ?string
    {
        return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }

    private function explainLesson(string $message, string $name)
    {
        $prompt = <<<PROMPT
Bạn là trợ giảng AI của hệ thống học trực tuyến. Học viên đang hỏi về nội dung một bài học.

Yêu cầu:
- Giải thích rõ ràng, ngắn gọn, dễ hiểu.
- Dựa vào câu hỏi để xác định học viên muốn hỏi bài gì.
- Không dùng thuật ngữ quá chuyên môn nếu không cần thiết.

Câu hỏi của học viên:
"$message"
PROMPT;

        $aiResponse = $this->queryGemini($prompt);
        $reply = $this->extractText($aiResponse) ?? 'Xin lỗi, mình chưa hiểu bài học bạn đang hỏi.';

        return $this->reply($reply, $name, false);
    }

    public function history()
    {
        if (Auth::check()) {
            $history = Auth::user()->chatMessages()->orderBy('created_at')->get();
            return response()->json(['history' => $history]);
        } else {
            return response()->json(['error' => 'Bạn cần đăng nhập để xem lịch sử chat.'], 401);
        }
    }
}