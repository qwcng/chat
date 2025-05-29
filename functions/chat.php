<?php if(isset($_GET['id'])):?>
<?php 
    include './components/profile.php'
    ?>
<div class="chat-app hide">
    <div class="header">
        <i onclick="back()" class="fa-solid fa-arrow-left fa-xl" style="color: #ffffff; margin: auto 10px;"></i>
        <img class="pfp" src="pfp/<?php echo $user->getAvatar($_GET['id']) ?>" alt="Chat">
        <i onclick="info()" class="fa-solid fa-gear fa-xl"
            style="color: #ffffff; margin: 25px 10px; position: absolute; right: 0;"></i>

        <div class="nick font"> <?php echo $chat->getSenderUsername($_GET['id']);?>
            <?php if($chat->isOnline($_GET['id'])){
                    echo "<p class='status online'>online </p>";
                }else{
                    echo "<p class='status offline'>offline </p>";   
                }?>

        </div>
    </div>



    <div class="chat-box " id="chatBox">


        <?php 
        
        
        $messages = $chat->getMessages($user->getUserId(),$_GET['id']);
        foreach ($messages as $message): ?>
        <div class="<?php echo $message['sender_id'] == $user->getUserId() ? 'outcoming' : 'incoming'; ?> ">
            <div class="message-data "><?php echo htmlspecialchars($message['message']); ?></div>
        </div>
        <?php endforeach; 
            
            ?>
        <!-- <div class="outcoming ">
                    <div class="message-data ">sIEMA <img src="banner2.jpg" alt=""> </div>
                    </div> -->


    </div>

    <div class="inputs" onsubmit="">
        <div><i class="fa-solid fa-image fa-xl" style="color: #ffffff;"></i></div>
        <textarea class="input-message" autocomplete="off" name="chat" onkeydown="clickPress(event)"
            oninput="height(this)" placeholder="Write a message"></textarea>
        <button onclick="sendMessage()" class="submit"><i class="fa-solid fa-paper-plane fa-xl"
                style="color: #FFFFFF;"></i></button>
    </div>
</div>

<?php else:
    ?>

<div class="mobile  shadow">

    <div class="  mobile-header">
        <img src='pfp/<?php echo $user->getAvatar()?>' lazy='load' class=' avatar' alt='Friend Avatar'>
        <h2 class="font "><?php echo $user->getUsername()?></h2>
    </div>

    <div class="friends-scroll">

        <?php foreach($friends as $friend):?>

        <!-- <div class=" "> -->
        <a href="?id=<?php echo $friend['id']?>" class="friend-scroll">
            <img src='pfp/<?php echo $user->getAvatar($friend['id'])?>' class=' avatar-scroll' alt='Friend Avatar'>
            <b class="font "><?php echo $chat->getSenderUsername($friend['id']) ?> </b>
        </a>
        <!-- </div> -->
        <?php endforeach;?>


    </div>
    <div class='friends'>

        <a style='text-decoration:none; margin: auto 0;' onclick="addFriendm();" class=" setting  selected ">
            <i class="fa-solid fa-user-plus fa-xl" style="color: #ffffff;"></i>
            <div class='nick r font '>Dodaj znajomego</div>
        </a>

        <form id="addFriendm" method="post" class="form toast">
            <h2 class="font">Dodaj znajomego</h2>
            <i class="fa-solid fa-xmark fa-xl" style="color:rgb(255, 28, 28); position:absolute; right:0; margin:5px;"
                onclick="addFriendm();"></i>
            <input name="username" type="text" class="input" placeholder="nazwa użytkownika ">
            <button type="submit" class="button font">Dodaj</button>
        </form>
        <div class="search selected">
            <form action="#">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <input type="text" class="search_input" placeholder="Search for friends..."
                    oninput="searchFriends(this)">
            </form>
        </div>

        <div id="friendsList" class="friends" style="width: 100%;">
            <div id="resultM"></div>
            <?php 
                    include 'friends.php';
                ?>
            <h3 class="font">Przychodzące zaproszenia</h3>
            <?php $requests = $user->getPendingFriends();
            foreach($requests as $request):?>
            <div class='friend '>
                <div class="">
                    <div class='avatar'><img src='pfp.png' alt='Friend' s Avatar'></div>
                    <div class="nick font">Userer</div>
                    <div class="message-s">
                        <form action="" method="POST" id="accept">
                            <input type="hidden" name="action" value="">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" onclick="this.form.action.value='accept';"
                                style="background: none; border: none;">
                                <i class="fa-solid fa-check fa-2xl" style="color:rgb(4, 224, 158);"></i>
                            </button>
                            <button type="submit" onclick="this.form.action.value='reject';"
                                style="background: none; border: none;">
                                <i class="fa-solid fa-xmark fa-2xl" style="color: #ff0000;"></i>
                            </button>
                        </form>
                    </div>
                </div>





            </div>
            <?php endforeach; ?>

        </div>




    </div>
</div>
<?php
 require 'components/mobile_bar.php';
?>



<?php endif;?>