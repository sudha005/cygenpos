                    <?php
                    foreach($item_category as $item_category_row ){
                    ?>
                    <div class="item">
                        <div class="product light">
                            <a href="#">
                        <img src="<?php echo base_url().$item_category_row['cat_image']; ?>" class="img-responsive">
                            </a>
                        </div>
                    </div>
                   <?php
                    }
                   ?>