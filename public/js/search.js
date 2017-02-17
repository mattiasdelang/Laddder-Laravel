/*$("document").ready(function(){


   $('#searchButton').click(function (){
        var keywords = $('#search-input').val();
            $('.projects-container').css('display', 'none');
            $('#search-results').css('display', 'block');

            $.ajax({
                    type: "GET",
                    url : "/search",
                    data: {test:keywords },
                    success : function(data){
                        console.log(data);
                       $('#search-results').html(data);
                    }
                },"json");

        });
});

*/
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})