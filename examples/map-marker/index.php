<!doctype html>
<title>Mapbox PHP Wrapper - Place Point on Map</title>
<style>
  * { box-sizing: border-box; }
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
  .form-group { margin-bottom: 5px; }
  input { width: 100%; padding: 7px 5px; }
  button { padding: 7px 10px; float: right; }
</style>

<article>
    <h1>Enter location:</h1>
    <div>
        <p>Type in a place, it could be an address or location of interest.</p>
        <form action="mapbox.php" method="POST">
            <div class="form-group">
                <input type="text" name="query" value="" placeholder="Enter Query:" />
            </div>
            <div class="form-group">
                <button type="submit">Search...</button>
            </div>
        </form>
    </div>
</article>
