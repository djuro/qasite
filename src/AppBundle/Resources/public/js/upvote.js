$(document).ready(function() {
    
    var $upvote = $(".upvote");
    
    $upvote.click(function(e) {
        e.preventDefault();
        var questionId = $(this).data('question');
        var route = Routing.generate('upvote_question', {'question':questionId});
        var $voteLabel = $("#votes-"+questionId);
        $.get(route, function(totalVotes) {
            $voteLabel.text(totalVotes);
        });
    });
});


