<?php

namespace App\Http\Controllers;

use App\Model\Comment;
use App\Model\Message;
use App\Model\Post;
use App\Model\Zan;
use Request;
use Validator;
use Auth;

class CommentController extends Controller
{
    //用户评论
    public function doComment(){

        //表单验证规则
        $validator = Validator::make(request()->all(),[
            'user_id' => 'required|integer|exists:users,id',
            'post_id' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()){
            //表单验证失败
            return $validator->errors();
        }

        $data = request(['user_id','post_id']);
        $data['content'] = request('my-editormd-html-code');

        $status = Comment::create($data);

        if ($status){
            //添加评论成功
            $post = Post::find(request('post_id'));
            $to_user_id = $post->user->id;
            if ($to_user_id != request('user_id')){
                Message::create([
                    'from_user_id'=>Auth::id(),
                    'to_user_id'=>$to_user_id,
                    'type'=>'comment',
                    'post_id'=>request('post_id'),
                    'CommentOrZan_id' => Comment::orderBy('id','asc')->first()['id'],
                ]);
            }
            return [
                'error' => '1',
                'msg' => '评论成功'
            ];
        }else{
            //添加评论失败
            return [
                'error' => '0',
                'msg' => '评论失败，请稍后重试'
            ];
        }
    }
    //删除评论
    public function delComment()
    {
        if (Auth::id() == request('user_id')){
            Comment::where('id',request('comment_id'))->delete();
            return [
                'error' => 0,
                'msg' => '删除成功'
            ];
        }else{
            return [
                'error' => 1,
                'msg' => '您没有权限操作'
            ];
        }

    }
    //采纳评论
    public function acceptComment()
    {
        $post_id = request('post_id');
        $comment_id = request('comment_id');
        $post_user_id = request('post_user_id');
        if (Auth::id() != $post_user_id){
            return [
              'error' => '1',
              'msg' => '您没有权限操作'
            ];
        }

        Post::where("id",$post_id)->update(['is_closed'=>true]);
        Comment::where('id',$comment_id)->update(['is_accept'=>true]);

        return [
            'error' => '0',
            'msg' => '采纳成功'
        ];

    }
    //点赞评论
    public function zan($comment_id){
        $zan = new Zan();
        $zan->user_id = Auth::id();
        $zan->comment_id = $comment_id;
        $status = $zan->save();
        if ($status){
            return [
                'error'=>'1',
                'msg'=>''
            ];
        }else{
            return [
                'error'=>'0',
                'msg'=>'点赞失败，请稍后重试'
            ];
        }

    }
    //取消赞评论
    public function unzan($comment_id){

        $status = Zan::where('user_id',Auth::id())->where('comment_id',$comment_id)->delete();

        if ($status){
            return [
                'error'=>'1',
                'msg'=>''
            ];
        }else{
            return [
                'error'=>'0',
                'msg'=>'取消赞失败，请稍后重试'
            ];
        }

    }
}
