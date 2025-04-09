<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Course;
use App\Models\Category;
use App\Models\Lesson;

class GeminiChatController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['reply' => 'Bạn cần đăng nhập để sử dụng chatbot.']);
        }

        return view('chat');
    }

    public function send(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['reply' => 'Bạn cần đăng nhập để sử dụng chatbot.']);
        }

        $userMessage = $request->input('message');
        $userName = Auth::user()->name ?? 'bạn';

        // Gợi ý lời chào nếu đây là tin nhắn đầu tiên
        if (!Session::has('chat_started')) {
            Session::put('chat_started', true);
            return response()->json(['reply' => "Chào $userName! Tôi có thể giúp gì cho bạn?"]);
        }

        // Kiểm tra nếu người dùng nói “nói rõ hơn”, “chi tiết hơn”
        if (preg_match('/(chi tiết hơn|nói rõ hơn|rõ hơn|thêm thông tin)/i', $userMessage)) {
            $previous = Session::get('previous_message');
            if ($previous) {
                $userMessage = "Hãy giải thích rõ hơn câu hỏi sau: \"$previous\"";
            } else {
                return response()->json(['reply' => "Bạn muốn biết rõ hơn về điều gì?"]);
            }
        } else {
            Session::put('previous_message', $userMessage); // lưu lại để dùng sau
        }

        // Gửi đến Gemini (có thể gắn transcript nếu muốn)
        $reply = $this->chatWithGemini($userMessage);

        return response()->json(['reply' => "Chào $userName! " . $reply]);
    }

    private function chatWithGemini($message)
    {
        // Nếu có nội dung bài học thì đưa vào prompt
        $transcript = ''; // TODO: lấy từ DB nếu có bài học
        $prompt = $transcript
            ? "Dựa trên nội dung sau: \"$transcript\".\nNgười dùng hỏi: \"$message\"\nTrả lời dễ hiểu, ngắn gọn."
            : "Người dùng hỏi: \"$message\"\nTrả lời dễ hiểu, ngắn gọn, không dùng Markdown.";

        $response = Http::post(env('GEMINI_API_URL') . '?key=' . env('GEMINI_API_KEY'), [
            'contents' => [[ 'parts' => [[ 'text' => $prompt ]] ]]
        ]);

        if ($response->failed()) {
            return 'Xin lỗi, hệ thống đang gặp lỗi. Vui lòng thử lại sau.';
        }

        $data = $response->json();
        return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi chưa hiểu câu hỏi.';
    }
}
