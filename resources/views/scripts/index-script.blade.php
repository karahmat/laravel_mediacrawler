<script type="text/javascript">
    const submitBtn = document.querySelector("#submitBtn");
    submitBtn.addEventListener('click', ()=>{
        document.querySelector(".progress").classList.toggle('inv');
        submitBtn.classList.toggle('inv');
    });
</script>  