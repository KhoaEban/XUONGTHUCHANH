<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;

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

        // Bước 1: Dùng AI để phân tích intent
        $prompt = <<<PROMPT
Phân tích câu sau và CHỈ trả về JSON đúng định dạng: { "intent": "..." }.
Không thêm giải thích hoặc ký tự thừa.
Các intent hợp lệ gồm: 'course_count', 'category_count', 'lesson_count', 'list_courses', 'explain_lesson', 'other'.
Câu: "$userMessage"
PROMPT;

        $aiIntentResponse = $this->queryGemini($prompt);
        $intent = $this->extractIntent($aiIntentResponse);

        // Bước 2: Xử lý intent
        $intentHandlers = [
            'course_count' => fn() => $this->reply("Hiện tại, chúng tôi có " . Course::count() . " khóa học.", $name),
            'category_count' => fn() => $this->reply("Hiện tại, chúng tôi có " . Category::count() . " danh mục.", $name),
            'lesson_count' => fn() => $this->reply("Hiện tại, chúng tôi có " . Lesson::count() . " bài học.", $name),
            'list_courses' => fn() => $this->listCourses($name),
            'explain_lesson' => fn() => $this->reply("Tính năng giải thích bài học sẽ sớm được triển khai!", $name),
            'other' => fn() => $this->chatWithGemini($userMessage, $name)
        ];

        return ($intentHandlers[$intent] ?? $intentHandlers['other'])();
    }

    private function reply(string $message, string $name)
    {
        return response()->json(['reply' => "Chào $name! $message"]);
    }

    private function listCourses($name)
    {
        $courses = Course::select('title')->take(10)->get();
        if ($courses->isEmpty()) {
            return $this->reply("Hiện tại chưa có khóa học nào.", $name);
        }

        $response = "Các khóa học hiện có:\n";
        foreach ($courses as $index => $course) {
            $response .= ($index + 1) . ". {$course->title}\n";
        }

        return $this->reply($response, $name);
    }

    private function chatWithGemini(string $message, string $name)
    {
        // Nếu chưa đăng nhập thì chỉ cho trả lời cơ bản
        if (!Auth::check()) {
            return $this->reply("Bạn cần đăng nhập để sử dụng đầy đủ chức năng của chatbot.", $name);
        }

        $response = $this->queryGemini($message);
        $reply = $this->extractText($response) ?? 'Xin lỗi, tôi chưa hiểu câu hỏi của bạn.';

        return $this->reply($reply, $name);
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
}
