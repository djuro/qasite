$(document).ready(function() {
    var $addComment = $("#add-comment");
    var $questionCommentForm = $("#question-comment-form");
    
    $addComment.click(function(e) {
        e.preventDefault();
        $questionCommentForm.show();
        $(this).hide();
    });
});

