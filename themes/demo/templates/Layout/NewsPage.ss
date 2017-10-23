<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
                <h4>Published by $Author on $Published.format("jS M Y")</h4>
                $Image.SetRatioSize(480,480) 
		<div class="content">$Content</div>
	</article>
<div class="pagination">
<% if $PreviousPublishedSibling %>
<a href="$PreviousPublishedSibling.Link">Previous</a>
<% end_if %>
<% if $Parent %>
<a href="$Parent.Link">List</a>
<% end_if %>
<% if $NextPublishedSibling %>
<a href="$NextPublishedSibling.Link">Next</a>
<% end_if %>
</div>
</div>
