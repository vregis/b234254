
<div class="main-container test-start-page">
    <div class="text1">hi!</div>
    <div class="text2">Discover</div>
    <div class="text2 text3">your business role</div>
    <div class="btn-wrap"><a href="/tests/progress" class="btn btn-cust lowercase">2-min test</a></div>
    <a href="/departments" class="skip">I know my roles</a>
</div>
<style>
    /*.page-content{background:#fff;}*/
</style>
<script>
    $(document).ready(function(){
        var mStart = $(window).height() / 2 - $(".test-start-page").height()/2 +"px";
        $(".test-start-page").css({"margin-top": mStart});
        
        $(window).resize(function(){
            var mStart = $(window).height() / 2 - $(".test-start-page").height() / 2 +"px";
            
            $(".test-start-page").css({"margin-top": mStart});
            
        });
        if((navigator.userAgent.indexOf ('Linux')!= -1 && navigator.userAgent.indexOf ('Android')== -1) || navigator.userAgent.indexOf ('Windows NT') != -1 || (navigator.userAgent.indexOf ('Mac')!= -1 && navigator.userAgent.indexOf ('iPad') == -1 && navigator.userAgent.indexOf ('iPhone') == -1)){
            // console.log("desktop");
        }else{
            $(".test-start-page .skip").popover({
                placement: "top",
                content : 'Please use computer to access the tool.'
            }).click(function(e){e.preventDefault();});
            // console.log("Mobile");
        }
    });

</script>
<!-- END CONTENT -->
