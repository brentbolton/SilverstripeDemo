<div class="content-container unit size3of4 lastUnit">  
    <article>
        <h1>$Title</h1>
    </article>
    <div class="myCaro">
    <% loop GalleryImages %>
        <div class="item">$Image.SetHeight(300)</div>
    <% end_loop %>
    </div>
    <article>
        $Content
    </article>
</div>
