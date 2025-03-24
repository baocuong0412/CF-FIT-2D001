<?php

namespace App\Http\Controllers\Include;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\RepliesRequest;
use App\Models\Comments;
use App\Models\Replies;
use App\Models\Rooms;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(CommentRequest $request, $id)
    {
        // Kiểm tra xem room có tồn tại không
        $room = Rooms::find($id);
        if (!$room) {
            return back()->withErrors(['error' => 'Phòng không tồn tại!']);
        }

        // Lưu bình luận vào database
        Comments::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'room_id' => $id,
        ]);

        return back()->with('success', 'Bình luận đã được gửi!');
    }

    public function replie(RepliesRequest $request, $id)
    {
        $comment = Comments::findOrFail($id); // Kiểm tra bình luận có tồn tại không

        // Lưu phản hồi vào database
        $reply = new Replies();
        $reply->reply_content = $request->reply_content;
        $reply->user_id = auth()->id();
        $reply->comment_id  = $comment->id; // Đánh dấu đây là phản hồi của bình luận

        $reply->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Phản hồi đã được gửi!',
            'reply' => [
                'user' => auth()->user()->name,
                'content' => $reply->reply_content,
                'created_at' => $reply->created_at->diffForHumans()
            ]
        ]);
    }
}
