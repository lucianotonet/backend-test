<script>

    @if( Session::has('success') )
        swal({
            title: "Great!",
            text: "{{ Session::get('success') }}",
            timer: 1500,
            button: false,
            icon: 'success'
        });
    @endif

    @if( Session::has('error') )
        swal({
            title: "Oops!",
            text: "{{ Session::get('error') }}",            
            button: true,
            icon: 'error'
        });
    @endif

    @if( Session::has('warning') )
        swal({
            title: "Warning!",
            text: "{{ Session::get('warning') }}",            
            button: true,
            icon: 'warning'
        });
    @endif

</script>
