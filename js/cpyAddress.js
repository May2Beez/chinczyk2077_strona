function myFunction() {

    var dummy = document.getElementById('cpyToClipp');
    //text = window.location.origin;
    //baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

    //dummy.value = text + "/play2077.php?id=";
    dummy.select();
    document.execCommand('copy');
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: 'success',
        title: 'Link skopiowany!'
      })
}

$( document ).ready(function() {
    document.getElementById('cpyToClipp').value = window.location.origin + "/play2077.php?id=";
});