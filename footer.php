
</div>
</div>
</div>
<script>
$('#expand_menu_button').click(function(){
    if ($('#mobile_nav').hasClass('hidden')){
        $('#mobile_nav').css('display', 'none').removeClass('hidden').slideDown('1000');
        $('#expand_menu_button').slideUp("500", function(){
            $('#collapse_menu_button').slideDown('500');
        });
    }
});
$('#collapse_menu_button').click(function(){
    if (!$('#mobile_nav').hasClass('hidden')){
        $('#mobile_nav').slideUp('1000', function(){
            $('#mobile_nav').addClass('hidden');
        });
        $('#collapse_menu_button').slideUp("500", function(){
            $('#expand_menu_button').slideDown('500');
        });
    }    
});

</script>
</body>
</html>