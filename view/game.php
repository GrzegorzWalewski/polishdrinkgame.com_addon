<div class="justify-content-center d-flex">
    <div class="content p-3 col-md-6">
        <div class="row text-center">
            <h1>Witaj w Polish Drink Game!</h1>
        </div>
        <div class="row text-center">
            <h2 id="gameTask" class="col"></h2>
        </div>
        <div class="row text-center mt-3">
            <h3 id="additionalTask" class="col"></h3>
        </div>
        <div class="row text-center">
            <div id="number"></div>
        </div>
        <div class="row text-center">
            <h4 id="playerMsgContainer" class="col"><span id="playerMsg"></span> <span id="player"></span></h4>
        </div>
        <div id="players" class="row text-center justify-content-center d-flex"></div>
    </div>
</div>
<script>
    let searchParams = new URLSearchParams(window.location.search)
    clicked = false;
    $( document ).ready(function() {
        // send dice click to game
        $('#number').on('click', function ()
        {
            if($('#player').text() == "" && clicked != true) {
                if(!$('#additionalTask').text().includes("roll"))
                {
                    clicked = true;
                }
                $.ajax({
                    method: "POST",
                    url: "click.php",
                    data: {gameId: <?php echo $_GET['gameId'] ?>, actionName: "clickDice", done: false}
                });
            }
        });
        reciveDataFromPDG();
    });
    /**
     * update information from game
     **/
    function reciveDataFromPDG()
    {
        $.ajax({
            method: "POST",
            url: "/read.php",
            data: {gameId: <?php echo $_GET['gameId'] ?>}
        })
            .done(function( msg ) {
                if(msg.status == "success")
                {
                    $('#gameTask').text(msg.gameTask);
                    switch (parseInt(msg.number)) {
                        case 1:
                            $('#number').html("<i class=\"fas fa-dice-one fa-10x\"></i>");
                            break;
                        case 2:
                            $('#number').html("<i class=\"fas fa-dice-two fa-10x\"></i>");
                            break;
                        case 3:
                            $('#number').html("<i class=\"fas fa-dice-three fa-10x\"></i>");
                            break;
                        case 4:
                            $('#number').html("<i class=\"fas fa-dice-four fa-10x\"></i>");
                            break;
                        case 5:
                            $('#number').html("<i class=\"fas fa-dice-five fa-10x\"></i>");
                            break;
                        case 6:
                            $('#number').html("<i class=\"fas fa-dice-six fa-10x\"></i>");
                            break;
                    }
                    players = "";
                    for(i=0;i < msg.gamers.length; i++)
                    {
                        players += '<span class="col-md-3">'+msg.gamers[i][4]+' ('+msg.gamers[i][2]+'/70)</span>';
                    }
                    $('#players').html(players);
                    $('#additionalTask').text(msg.additionalTask);
                    if(isMyTurn(msg.player))
                    {
                        $('#player').text("");
                        $('#playerMsgContainer').removeClass('text-info');
                        $('#playerMsgContainer').addClass('text-success');
                        $('#playerMsg').text("Teraz Twoja kolej!");
                        $('#number i').css('color', 'green');
                    }
                    else
                    {
                        clicked = false;
                        $('#player').text(msg.player);
                        $('#playerMsgContainer').removeClass('text-success');
                        $('#playerMsgContainer').addClass('text-info');
                        $('#playerMsg').text("Ruch gracza: ");
                        $('#number i').css('color', 'white');
                    }
                }
                reciveDataFromPDG();
            });
    }

    /**
     * Check is player turn
     * @param username
     * @returns {boolean}
     */
    function isMyTurn(username)
    {
        if(searchParams.get('username') == username)
        {
            return true;
        }
        return false;
    }
</script>