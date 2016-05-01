<?php
/*!
 * 搜索框模版
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
  <div class="form-group">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="搜索…" name="s" id="s" required="">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-default" id="searchsubmit"><span class="glyphicon glyphicon-search"></span></button>
      </span>
    </div>
  </div>
</form>