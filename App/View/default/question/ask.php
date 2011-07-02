<form action="" method="post" id="question_ask_form">
	Title:
	<br>
	<input type="text" id="question_title" name="title" size="50" />
	<br><br>
	Content<br><textarea id="question_content" name="content" rows="10" cols="50"></textarea>
	<br><br>
	<div class="ui-widget">
		<label>Tags: </label>
		<select id="combobox" name="tags">
			<option value="">Select one...</option>
			<?php foreach($aTags as $aTag) { ?>
			<option value="<?php echo $aTag['id']; ?>"><?php echo $aTag['title']; ?></option>
			<?php } ?>
		</select>
	</div>	
	<input type="hidden" name="tags" id="hidden_tags" value="html" />
	<br><br>
	<input type="submit" value="Ask" />
</form>


<script type="text/javascript">
$('#question_ask_form').submit(function() {
	if($('#question_title').val() == '') {
		return false;
	}
	if($('#question_content').val() == '') {
		return false;
	}
});

(function( $ ) {
	$.widget( "ui.combobox", {
		_create: function() {
			var self = this,
				select = this.element.hide(),
				selected = select.children( ":selected" ),
				value = selected.val() ? selected.text() : "";
			var input = $( "<input>" )
				.insertAfter( select )
				.val( value )
				.autocomplete({
					delay: 0,
					minLength: 0,
					source: function( request, response ) {
						var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
						response( select.children( "option" ).map(function() {
							var text = $( this ).text();
							if ( this.value && ( !request.term || matcher.test(text) ) )
								return {
									label: text.replace(
										new RegExp(
											"(?![^&;]+;)(?!<[^<>]*)(" +
											$.ui.autocomplete.escapeRegex(request.term) +
											")(?![^<>]*>)(?![^&;]+;)", "gi"
										), "<strong>$1</strong>" ),
									value: text,
									option: this
								};
						}) );
					},
					select: function( event, ui ) {
						ui.item.option.selected = true;
						self._trigger( "selected", event, {
							item: ui.item.option
						});
					},
					change: function( event, ui ) {
						if ( !ui.item ) {
							var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
								valid = false;
							select.children( "option" ).each(function() {
								if ( this.value.match( matcher ) ) {
									this.selected = valid = true;
									return false;
								}
							});
							if ( !valid ) {
								// remove invalid value, as it didn't match anything
								$( this ).val( "" );
								select.val( "" );
								return false;
							}
						}
					}
				})
				.addClass( "ui-widget ui-widget-content ui-corner-left" );

			input.data( "autocomplete" )._renderItem = function( ul, item ) {
				return $( "<li></li>" )
					.data( "item.autocomplete", item )
					.append( "<a>" + item.label + "</a>" )
					.appendTo( ul );
			};

			$( "<button>&nbsp;</button>" )
				.attr( "tabIndex", -1 )
				.attr( "title", "Show All Items" )
				.insertAfter( input )
				.button({
					icons: {
						primary: "ui-icon-triangle-1-s"
					},
					text: false
				})
				.removeClass( "ui-corner-all" )
				.addClass( "ui-corner-right ui-button-icon" )
				.click(function() {
					// close if already visible
					if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
						input.autocomplete( "close" );
						return;
					}

					// pass empty string as value to search for, displaying all results
					input.autocomplete( "search", "" );
					input.focus();
					return false;
				});
		}
	});
})( jQuery );

jQuery(document).ready(function($) {

	$( "#combobox" ).combobox();
//	$('#')
	/*
	$('.ui-widget .ui-button').click() {
		return false;
	}
	*/
	
	$('#question_ask_form').submit(function() {
		
	});
	
});
	
</script>

<style type="text/css">
.ui-widget { font-size: 13px; }
.ui-button { margin-left: -1px; padding-bottom: 5px; padding-top: 2px; }
.ui-button-icon-only .ui-button-text { margin: 0; padding: 0; } 
.ui-autocomplete-input { margin: 0; padding: 0;  height: 25px; }


</style>