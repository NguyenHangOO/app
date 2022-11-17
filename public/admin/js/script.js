$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function removeRow(id,url){
    if(confirm('Are you sure you want to delete?')){
        $.ajax({
            type : 'DELETE',
            datatype: 'JSON',
            data : {id},
            url:url,
            success: function (result){
                if(result.error === false){
                    alert(result.message);
                    location.reload();
                }else{
                    alert('Clear error please try again');
                }
            }
        });
    }
}
