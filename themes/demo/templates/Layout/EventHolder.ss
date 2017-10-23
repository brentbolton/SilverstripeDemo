<div class="content-container unit size3of4 lastUnit">  
    <article>
        <h1>$Title</h1>
    </article>
    $SearchForm
    <div class="clear"></div>
    <% loop $Results %>
        <article>
            <h2>$Title</h2>
            <h5>From $StartTime.format("jS M Y G:i:s") to $EndTime.format("jS M Y G:i:s")</h5>
            <div class="holder-item">
                    <p>$Content.FirstParagraph</p>
            <a href="$Link" title="Read more on &quot;{$Title}&quot;">Read more &gt;&gt;</a>
        </article>
    <% end_loop %>
</div>
