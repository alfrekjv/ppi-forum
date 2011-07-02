<section id="question_view">
	
	<div class="generic_box" style="padding: 25px;">
	
		<h1><a href="/questions/4103050/trouble-with-css-overflow-property" class="question-hyperlink"><?php echo $aQuestion['title']; ?></a></h1>
	
		<section id="vote_updown">
			
			<div class="vote">
			    <input type="hidden" value="4103050">
			    <span id="question_id_<?php echo $aQuestion['id']; ?>" class="vote-up vote-up-off" title="This question is useful and clear (click again to undo)"></span>
			    <span class="vote-count-post"><?php echo $aQuestion['votes']; ?></span>
			    <span class="vote-down vote-down-off" title="This question is unclear or not useful (click again to undo)"></span>
			
			    <span class="star-off" title="This is a favorite question (click again to undo)"></span>
			    <div class="favoritecount"><b></b></div>    
			
			</div>		
		
		</section>
		
		<section id="message_body">
		
			<p><?php echo nl2br($aQuestion['content']); ?></p>
			<div class="post-taglist">
			
				<?php foreach($aQuestion['tags'] as $aTag) { ?>
					<a class="post-tag"><?php echo $aTag['title']; ?></a>
				<?php } ?>
			
			</div>				
			
		</section>
			
		<section id="question_details">
			<p>Tagged</p>
			<p class="value">
			<?php foreach($aQuestion['tags'] as $aTag) { ?>
			<a href="<?php echo $baseUrl; ?>" class="post-tag"><?php echo $aTag['title']; ?></a>
			<?php } ?>
			</p>
			<p>Views</p>
			<p class="value"><?php echo $aQuestion['views']; ?></p>
		</section>		
			
		<div class="clear"></div>
		
		
	</div>
	

	
			
	<section id="owner" class="owner post-signature">
	
		<div class="user-info">
			<div class="user-action-time">asked <span title="2010-11-05 02:08:48Z" class="relativetime bold">30 mins ago</span></div>
			<div class="user-gravatar32">
				<a href="<?php echo $baseUrl; ?>user/profile/<?php echo $aQuestion['owner']['username']; ?>"><img src="http://www.gravatar.com/avatar/bba8a1d044a8309d5f9b562ddd3b8bef?s=32&amp;d=identicon&amp;r=PG" height="32" width="32" alt=""></a>
			</div>
			<div class="user-details">
				<a href="<?php echo $baseUrl; ?>user/profile/<?php echo $aQuestion['owner']['username']; ?>"><?php echo $aQuestion['owner']['first_name']; ?> <?php echo $aQuestion['owner']['last_name']; ?></a>
				<br>
				<span>Join Date: 10/10/2010</span>
				<br>
				<span class="reputation-score" title="reputation score"><?php echo (int) $aQuestion['owner']['points']; ?></span>
				<span title="1 gold badge">
					<span class="badge1"></span>
					<span class="badgecount">1</span>
				</span>
				<span title="7 silver badges">
					<span class="badge2"></span>
					<span class="badgecount">7</span>
				</span>
				<span title="28 bronze badges">
					<span class="badge3"></span>
					<span class="badgecount">28</span>
				</span>
			</div>
		</div>
		<div class="clear"></div>
<!--	<div class="accept-rate accept-answer-link" title="this user has accepted an answer for 190 of 205 eligible questions">93% accept rate</div>-->
	</section>



</section>