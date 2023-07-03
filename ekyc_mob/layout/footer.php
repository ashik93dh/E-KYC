

<footer class="position-relative" >
<div style="float: right; margin-right:3em;">
  <?php if (isset($_SESSION['user'])){
            echo '<a class="btn btn-submit"  href="?logout" role="button"  id="logout-main" >Exit</a>';
          } ?> 
</div>
</footer>
<script type="text/javascript" src="resources/js/jquery-3.6.0.slim.min.js"></script>
<script type="text/javascript" src="resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="resources/js/main.js"></script>
<script type="text/javascript" src="resources/js/sweetalert.js"></script>

</html>
