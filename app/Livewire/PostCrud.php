<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostCrud extends Component
{
    public $updateMode = false;
    public $title, $content, $postId;
    protected $listeners = ['deletePost' => 'delete'];

    protected $rules = [
        'title' => 'required|min:3|max:100',
        'content' => 'required|min:5',
    ];

    protected $messages = [
        'title.required' => 'The title is required.',
        'title.min' => 'The title must be at least 3 characters.',
        'content.required' => 'The content is required.',
        'content.min' => 'The content must be at least 5 characters.',
    ];

    public function render()
    {
        return view('livewire.post-crud', [
            'posts' => Post::latest()->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetFields()
    {
        $this->title = '';
        $this->content = '';
        $this->postId = null;
        $this->updateMode = false;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Post Created Successfully.');
        $this->resetFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        $post = Post::find($this->postId);
        $post->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Post Updated Successfully.');
        $this->resetFields();
    }

    public function delete($id)
    {
        Post::findOrFail($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }
}
