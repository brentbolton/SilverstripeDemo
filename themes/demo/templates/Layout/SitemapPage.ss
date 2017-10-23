<div class="content-container unit size3of4 lastUnit">  
    <article>
        <h1>$Title</h1>
        $Content        
        <div class="content">$Content</div>
    </article>

<% loop $SiteList.GroupedBy(TitleFirstLetter) %>
    <h3>$TitleFirstLetter.UpperCase</h3>
    <ul>
        <% loop $Children %>
            <li>$Title</li>
        <% end_loop %>
    </ul>
<% end_loop %>


</div>
