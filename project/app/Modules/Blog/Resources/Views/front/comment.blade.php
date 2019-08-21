<span class="level1comment" id="{{$comment->id}}">
	<span class="userInfo">
		<span class="left">
			<span class="top">
				<span class="userImg"></span>
				<span class="name">{{ $comment->name }}</span>
			</span>
		</span>
		<span class="right">{{ format_current_date_for_last_blog($comment->created_at) }}</span>
	</span>
	<span class="text">{{ $comment->comment }}</span>
	<button type="button" id="{{ $comment->id }}" class="addComment">{{ trans('blog::front.answer') }}</button>
</span>
@if ($comment->children->isNotEmpty())
    @foreach($comment->children as $sub_comment)
        <span class="level2comment">
			@include('blog::front.comment', ['comment' => $sub_comment])
		</span>
    @endforeach
@endif
