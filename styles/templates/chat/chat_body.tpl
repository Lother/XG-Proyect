<script language="JavaScript" type="text/javascript" src="scripts/chat.js"></script>

<br /><br /><br /><br /><br />

<table align="center"><tbody>

<tr><td class="c"><b>{chat_disc}</b></td></tr>

<tr><th><div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 305px; overflow:hidden;"></div></th></tr>

<tr><th>{chat_message}: <input name="msg" type="text" id="msg" size="80" maxlength="100" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"><input type="hidden" name="ally_id" value="{ally_id}" id="ally_id" onClick="addMessage()"><input type="button" name="send" value="{chat_send}" id="send" onClick="addMessage()"></th></tr>

</tbody></table>

<br />
<table width="355" align="center"><tbody>

<tr><td colspan="2" class="c"><b>{chat_short}</b></td></tr>

<tr><th colspan="2"><img src="styles/skins/evolution/smileys/cry.png" align="absmiddle" title=":c" alt=":c" width="12" height="12" onClick="addSmiley(':c')">
		    <img src="styles/skins/evolution/smileys/confused.png" align="absmiddle" title=":/" alt=":/" width="12" height="12" onClick="addSmiley(':/')">
		    <img src="styles/skins/evolution/smileys/dizzy.png" align="absmiddle" title="o0" alt="o0" width="12" height="12" onClick="addSmiley('o0')">
		    <img src="styles/skins/evolution/smileys/happy.png" align="absmiddle" title="^^" alt="^^" width="12" height="12" onClick="addSmiley('^^')">
		    <img src="styles/skins/evolution/smileys/lol.png" align="absmiddle" title=":D" alt=":D" width="12" height="12" onClick="addSmiley(':D')">
		    <img src="styles/skins/evolution/smileys/neutral.png" align="absmiddle" title=":|" alt=":|" width="12" height="12" onClick="addSmiley(':|')">
		    <img src="styles/skins/evolution/smileys/smile.png" align="absmiddle" title=":)" alt=":)" width="12" height="12" onClick="addSmiley(':)')">
		    <img src="styles/skins/evolution/smileys/omg.png" align="absmiddle" title=":o" alt=":o" width="12" height="12" onClick="addSmiley(':o')">
		    <img src="styles/skins/evolution/smileys/tongue.png" align="absmiddle" title=":p" alt=":p" width="12" height="12" onClick="addSmiley(':p')">
		    <img src="styles/skins/evolution/smileys/sad.png" align="absmiddle" title=":(" alt=":(" width="12" height="12" onClick="addSmiley(':(')">
		    <img src="styles/skins/evolution/smileys/wink.png" align="absmiddle" title=";)" alt=";)" width="12" height="12" onClick="addSmiley(';)')">
		    <img src="styles/skins/evolution/smileys/shit.png" align="absmiddle" title=":s" alt=":s" width="12" height="12" onClick="addSmiley(':s')"></th></tr>

<tr><th width="60"><b>{chat_text}</b><br /><i>{chat_text}</i><br /><u>{chat_text}</u><br /><a href="http://xgp.twbbs.org" target="_blank">{chat_text}</a><br /><font color="red">{chat_text}</font></th>

<th>[b]{chat_text}[/b]<br />[i]{chat_text}[/i]<br />[u]{chat_text}[/u]<br />[a=http://xgp.twbbs.org]{chat_text}[/a]<br />[c=blue|yellow|green|pink|red|orange]{chat_text}[/c]</th></tr>

</tbody></table>
