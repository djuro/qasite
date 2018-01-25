$(document).ready(function() {
    //var $addComment = $("#add-comment");
    var $questionCommentForm = $("#question-comment-form");
    
//    $addComment.click(function(e) {
//        e.preventDefault();
//        $questionCommentForm.show();
//        $(this).hide();
//    });
    
    var $addComment = $(".add-comment");
    
    $addComment.click(function(e) {
        e.preventDefault();
        var $formContainer = $(this).parent();
        var questionId = $(this).data('question');
        var answerId = $(this).data('answer');
        //var route = Routing.generate('question_render_comment_form');
        $.post('http://qasite.com/app_dev.php/question/render-comment-form', {'question':questionId, 'answer':answerId}, function(data) {
            $formContainer.append(data);
        },'html');
    });
    
});

