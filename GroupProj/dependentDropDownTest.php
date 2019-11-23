<html>
<head>
</head>

<?php require_once('../../mysqli_config.php'); ?>

<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<script>
function getAlbum(value){
  alert("gets");
  $.ajax({
    type:'POST',
    url: "get_Album.php",
    data: 'artist_ID='+value,
    success: function(data){
      $("#album_list").html(data);
    }
  });
}
</script>

<body>
  <form>
    <label>Artist: </label>

    <select id = 'artist_list' onchange="getAlbum(this.value);">
      <option value=""> Select Artist</option>
      <?php
        $artistQuery = "SELECT * from Artist";
        $result1 = mysqli_query($dbc,$artistQuery);
        while($row = mysqli_fetch_array($result1))
        {
          ?>
          <option value="<?php echo $row['artist_ID'];?>"> <?php echo $row["artist_Name"];?></option>
          <?php
        }
      ?>
    </select>
    <label>Album: </label>
    <select id = 'album_list'>
      <option value=""> Select Album</option>
    </select>

</body>
</html>
