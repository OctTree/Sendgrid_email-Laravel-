@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div id="comments" class="comments-area">
                    <div id="respond" class="comment-respond">
                        <h3 id="reply-title" class="comment-reply-title">
                            <span>Leave a Reply</span>
                            <small>
                                <a rel="nofollow" id="cancel-comment-reply-link"
                                    href="/send-email-in-laravel-with-sendgrid/#respond" style="display:none;">Cancel
                                    reply</a>
                            </small>
                        </h3>
                        <form action="/email_action" method="post" id="commentform" class="comment-form" novalidate="">
                            <p class="comment-notes">
                                <span id="email-notes">Your email address will not be published.</span> Required fields are
                                marked <span class="required">*</span>
                            </p>
                            <p class="comment-form-email"><label for="email">From<span class="required">:</span></label>
                                <input id="email_from" name="email_from" type="email" value="{{ Auth::user()->email }}" size="30" maxlength="100"
                                    aria-describedby="email-notes" required="required" disabled>
                            </p>
                            <p class="comment-form-email"><label for="email">To<span class="required">:</span></label>
                                <input id="email_to" name="email_to" type="email" value="" size="30" maxlength="100"
                                    aria-describedby="email-notes" required="required">
                            </p>
                            <p class="comment-form-text"><label for="text">Subject<span class="required">:</span></label>
                                <input id="subject" name="subject" type="text" value="" size="30" maxlength="100"
                                    aria-describedby="email-notes" required="required">
                            </p>
                            <p class="comment-form-comment">
                                <label for="email_content">Content</label><br>
                                <textarea id="email_content" name="email_content" cols="45" rows="8" maxlength="65525"
                                    required="required"></textarea>
                            </p>
                            <p class="form-submit"><input name="submit" type="submit" id="submit" class="btn btn-submit"
                                    value="Post Comment">
                            <input type="hidden" name="user_ID" value="278" id="user_ID" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="campaign_ID" id="campaign_ID" value="0">
                            </p>
                        </form>
                    </div><!-- #respond -->
                </div>
        </div>
    </div>
</div>
@endsection
