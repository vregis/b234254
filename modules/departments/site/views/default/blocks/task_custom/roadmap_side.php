<link rel="stylesheet" type="text/css" href="/css/roadmap.css">
<div class="wrapper">
   <div class="step">
    <div class="form-md-radios md-radio-inline b-page-checkbox-wrap">
        <div class="progress"></div>
        <div class="md-radio item-1 has-test b-page-checkbox done" title="Registration" data-toggle="popover">
            <input type="radio" id="Roadmap[0]" name="Roadmap" class="md-radiobtn" value="1">
            <label for="Roadmap[0]">
                <span></span>
                <span class="check"></span>
                <span class="box" style="cursor: default" onclick="return false;"><i class="fa fa-check font-green-jungle"></i></span>
            </label>
        </div>
        <div class="md-radio item-2 has-test b-page-checkbox" title="Test" data-toggle="popover">
            <input type="radio" id="Roadmap[1]" name="Roadmap" class="md-radiobtn" value="2">
            <label for="Roadmap[1]">
                <span></span>
                <span class="check"></span>
                <span class="box" style="cursor: default" onclick="return false;"><i class="fa fa-check font-green-jungle"></i>2</span>
            </label>
        </div>
        <div class="md-radio item-3 has-test b-page-checkbox" title="Profile" data-toggle="popover">
            <input type="radio" id="Roadmap[2]" name="Roadmap" class="md-radiobtn" value="3">
            <label for="Roadmap[2]">
                <span></span>
                <span class="check"></span>
                <span class="box" style="cursor: default" onclick="return false;"><i class="fa fa-check font-green-jungle"></i>3</span>
            </label>
        </div>
        <div class="md-radio item-4 has-test b-page-checkbox" title="Idea" data-toggle="popover">
            <input type="radio" id="Roadmap[0]" name="Roadmap" class="md-radiobtn" value="3">
            <label for="Roadmap[0]">
                <span></span>
                <span class="check"></span>
                <span class="box" style="cursor: default" onclick="return false;"><i class="fa fa-check font-green-jungle"></i>4</span>
            </label>
        </div>
        <div class="md-radio item-5 has-test b-page-checkbox" title="Benefits" data-toggle="popover">
            <input type="radio" id="Roadmap[1]" name="Roadmap" class="md-radiobtn" value="4">
            <label for="Roadmap[1]">
                <span></span>
                <span class="check"></span>
                <span class="box" style="cursor: default" onclick="return false;"><i class="fa fa-check font-green-jungle"></i>5</span>
            </label>
        </div>
        <div class="md-radio item-6 has-test b-page-checkbox" title="Share idea" data-toggle="popover">
            <input type="radio" id="Roadmap[2]" name="Roadmap" class="md-radiobtn" value="5">
            <label for="Roadmap[2]">
                <span></span>
                <span class="check"></span>
                <span class="box" style="cursor: default" onclick="return false;"><i class="fa fa-check font-green-jungle"></i>6</span>
            </label>
        </div>
    </div>
</div> 
</div>

<script>
    $(document).ready(function(){
        $("#side_road .item-1").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-1" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Suspendisse molestie in augue ac rhoncus. Donec tempus eros id rutrum sollicitudin. Nulla nec porta nisi. Donec sapien sapien, euismod ut tempus et, pharetra et felis. In hac habitasse platea dictumst. Proin neque ante, vulputate vitae libero vel, blandit molestie diam. <div class='text-center'>Completed</div>"
        });
    });
</script>