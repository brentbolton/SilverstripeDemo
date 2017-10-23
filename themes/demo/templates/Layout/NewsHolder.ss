<div class="content-container unit size3of4 lastUnit">  
    <article>
        <h1>$Title</h1>
        $Content        
    </article>
    <% loop $PaginatedPages %>
        <% if $Parent.HighlightEveryNthStory %>
            <% if Modulus($Parent.HighlightEveryNthStory, $Top.PaginationOffset ) == 0 %> 
        <article class="highlight-article">
            <% else %>
        <article>
            <% end_if %>
        <% else %>
        <article>
        <% end_if %>
            <h2>$Title</h2>
            <h5>$Published.format("jS M Y"), by $Author</h5>
            <div class="holder-item">
                <div class="holder-img">	
                    $Image.SetRatioSize(200,200)
                </div>
                    <p>$Content.FirstParagraph</p>
            <a href="$Link" title="Read more on &quot;{$Title}&quot;">Read more &gt;&gt;</a>
        </article>
    <% end_loop %>

<% if $PaginatedPages.MoreThanOnePage %>
    <article>
    <div class="pagination">
    <% if $PaginatedPages.NotFirstPage %>
        <a href="$PaginatedPages.PrevLink">&laquo</a>
    <% end_if %>
    <% loop $PaginatedPages.Pages %>
        <% if $CurrentBool %>
            <a class="active">$PageNum</a>
        <% else %>
            <% if $Link %>
                <a href="$Link">$PageNum</a>
            <% else %>
                ...
            <% end_if %>
        <% end_if %>
        <% end_loop %>
    <% if $PaginatedPages.NotLastPage %>
        <a href="$PaginatedPages.NextLink">&raquo;</a>
    <% end_if %>
    </div>
    </article>
<% end_if %>
</div>
