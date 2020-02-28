<div >

<table>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>ITEM</th>
                        <th>COLOR</th>
                        <th>PATTERN</th>
                        <th>PRICE</th>
                        <th>LOCATION</th>
                      </tr>
                    </thead>
                  <tbody>
                    <?php
                      function dbAccess(){
                        include 'db_connection.php' ;
                        $name = $_POST[variables.name];
                        $color = $_POST[variables.color];
                        $pattern = $_POST[variables.pattern];
                        $query = "SELECT * FROM items WHERE name='$name' AND color='$color' AND pattern ='$pattern'";
                        $conn = OpenCon();
                        $data = mysqli_query($conn,$query) or die('Error');
                        CloseCon($conn);
                        echo mysqli_num_rows($data);
                      if(mysqli_num_rows($data)>0){
                        while($row = mysqli_fetch_assoc($data)){
                          $id = $row['id'];
                          $name = $row['name'];
                          $color = $row['color'];
                          $pattern = $row['pattern'];
                          $price = $row['price'];
                          $location = $row['location'];
                          ?>
                          <tr>
                          <td><?php echo $id ?></td>
                          <td><?php echo $name ?></td>
                          <td><?php echo $color ?></td>
                          <td><?php echo $pattern ?></td>
                          <td><?php echo $price ?></td>
                          <td><?php echo $location ?></td>
                          </tr>
                          <?php
                         }
                      }else{
                        ?>
                        <tr>
                          <td>Records not found</td>
                        </tr>
                        <?php
                      }
                      }
                      
                      ?>
                      <!-- if(isset($_POST['add'])){
                        $color = $_POST['color'];
                        $pattern = $_POST['pattern'];
                        $name = $_POST['name'];

                        if($name!= "" || $pattern != "" || $color != ""){
                          $query = "SELECT * FROM items WHERE image_text = '$name'|| color = '$color' || pattern = '$pattern'";
                          OpenCon();
                         

                          
                         }
                      }  

                    ?> -->
                  </tbody>
                  </table>
            </div>