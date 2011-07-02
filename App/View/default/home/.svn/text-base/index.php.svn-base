<ul>
<?php foreach($aTopQuestions as $question) { ?>
	<li>
		<?php echo (int) $question['views']; ?> Views - 
		<?php echo $question['numAnswers']; ?> Answers - 
		<?php echo $question['numVotes']; ?> Votes -
		<a href="<?php echo $baseUrl; ?>question/view/<?php echo $question['id']; ?>/<?php echo str_replace(' ', '-', $question['title']); ?>"><?php echo $question['title']; ?></a>
	</li>
<?php } ?>
</ul>