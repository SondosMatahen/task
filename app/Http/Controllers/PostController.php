<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;


class PostController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $posts = Post::where('active', '1')->orderBy('created_at', 'desc')->paginate(5);
    $title = 'Latest Posts';
    return view('home')->withPosts($posts)->withTitle($title);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create(Request $request)
  {
    if ($request->user()->can_post()) {
      return view('posts.create');
     } else {
      return redirect('/')->withErrors('You have not sufficient permissions for writing post');
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(PostFormRequest $request)
  {
    $post = new Post();
    $post->title = $request->get('title');
    $post->body = $request->get('body');
    $post->slug = Str::slug($post->title);

    $duplicate = Post::where('slug', $post->slug)->first();
    if ($duplicate) {
      return redirect('new-post')->withErrors('Title already exists.')->withInput();
    }

    $post->author_id = $request->user()->id;
    if ($request->has('save')) {
      $post->active = 0;
      $message = 'Post saved successfully';
    } else {
      $post->active = 1;
      $message = 'Post published successfully';
    }
    $post->save();
    return redirect('edit/' . $post->slug)->withMessage($message);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($slug)
  {
    $post =Post:: where('slug', $slug)->first();

    if ($post) {
      if ($post->active == false)
        return redirect('/')->withErrors('requested page not found');
      $comments = $post->comments;
    } else {
      return redirect('/')->withErrors('requested page not found');
    }
    return view('posts.show')->withPost($post)->withComments($comments);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(Request $request, $slug)
  {
    $post =Post:: where('slug', $slug)->first();
    if ($post && ($request->user()->id == $post->author_id || $request->user()->is_admin()))
      return view('posts.edit')->with('post', $post);
    else {
      return redirect('/')->withErrors('you have not sufficient permissions');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request)
  {
    $post_id = $request->input('post_id');
    $post =Post:: find($post_id);
    if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
      $title = $request->input('title');
      $slug = Str::slug($title);
      $duplicate =Post:: where('slug', $slug)->first();
      if ($duplicate) {
        if ($duplicate->id != $post_id) {
          return redirect('edit/' . $post->slug)->withErrors('Title already exists.')->withInput();
        } else {
          $post->slug = $slug;
        }
      }

      $post->title = $title;
      $post->body = $request->input('body');

      if ($request->has('save')) {
        $post->active = 0;
        $message = 'Post saved successfully';
        $landing = 'edit/' . $post->slug;
      } else {
        $post->active = 1;
        $message = 'Post updated successfully';
        $landing = $post->slug;
      }
      $post->save();
      return redirect($landing)->withMessage($message);
    } else {
      return redirect('/')->withErrors('you have not sufficient permissions');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    //
    $post =Post::find($id);
    if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
      $post->delete();
      $data['message'] = 'Post deleted Successfully';
    } else {
      $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
    }

    return redirect('/')->with($data);
  }
}
