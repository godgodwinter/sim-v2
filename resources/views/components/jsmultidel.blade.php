<div>
    <script>
        // console.log('asdad');
        $().jquery;
        $.fn.jquery;
        $(function(e){
            $("#chkCheckAll").click(function(){
                $(".checkBoxClass").prop('checked',$(this).prop('checked'));
            })

            $("#deleteAllSelectedRecord").click(function(e){
                e.preventDefault();
                var allids=[];
                    $("input:checkbox[name=ids]:checked").each(function(){
                        allids.push($(this).val());
                    });

            $.ajax({
                url:"{{ $link }}",
                type:"DELETE",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function(response){
                    $.each(allids,function($key,val){
                            $("#sid"+val).remove();

                            Swal.fire({
                                icon: 'warning',
                                title: 'Data berhasil dihapus!',
                                // text: 'Something went wrong!',
                                showConfirmButton: true,
                                timer: 1000
                            })
                    })
                }
            });

            })

        });
    </script>
</div>
