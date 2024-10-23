$(document).ready(function(){
    load_data();

    function load_data(query){
        $.ajax({
            url:"process.php",
            method:"POST",
            data: {query: query},
            success:function(data){
                $('#out_put').html(data);
            }
        });
    }
    $("#in_put").keyup(function(){
        var search = $(this).val();
        if (search != ''){
            load_data(search);
        }else{
            load_data();
        }
    });
});