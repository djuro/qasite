$(document).ready(function() {
   
    
    var $addAnswerComment = $(".add-answer-comment");
    
    var $addQuestionComment = $(".add-question-comment");
    
    $addQuestionComment.click(function(e) {
        e.preventDefault();
        var $formContainer = $(this).parent();
        var questionId = $(this).data('question');
        //var answerId = $(this).data('answer');
        var route = Routing.generate('render_question_comment_form');
        $.post(route, {'question':questionId}, function(data) {
            $formContainer.html(data);
        },'html');
    });
    
    $addAnswerComment.click(function(e) {
        e.preventDefault();
        var $formContainer = $(this).parent();
        var questionId = $(this).data('question');
        var answerId = $(this).data('answer');
        var route = Routing.generate('render_answer_comment_form');
        $.post(route, {'question':questionId, 'answer':answerId}, function(data) {
            $formContainer.html(data);
        },'html');
    });
    
});

