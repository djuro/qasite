$(document).ready(function() {
    
    var $downVote = $(".downvote");
    
    $downVote.click(function(e) {
        e.preventDefault();
        var questionId = $(this).data('question');
        var route = Routing.generate('downvote_question', {'question':questionId});
        var $voteLabel = $("#votes-"+questionId);
        $.get(route, function(totalVotes) {
            $voteLabel.text(totalVotes);
        });
    });
});


