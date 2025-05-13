
<div style="max-width: 700px; margin: auto;">
    @if (session()->has('message'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
        <div>
            <input type="text" wire:model.lazy="title" placeholder="Title">
            @error('title') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <textarea wire:model.lazy="content" placeholder="Content"></textarea>
            @error('content') <div style="color: red;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">{{ $updateMode ? 'Update' : 'Create' }}</button>
            @if($updateMode)
                <button type="button" wire:click="resetFields">Cancel</button>
            @endif
        </div>
    </form>

    <hr>

    <h3>Posts</h3>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td style="word-break: break-all; overflow-wrap: break-word;">{{ $post->content }}</td>
                    <td>
                        <button wire:click="edit({{ $post->id }})">Edit</button>
                        <button type="button" onclick="confirmDeletion({{ $post->id }})">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No posts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    
</div>


<script>
    function confirmDeletion(id) {
        if (confirm('Are you sure?')) {
            Livewire.dispatch('deletePost', { id: id });
        }
    }
</script>