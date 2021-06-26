wuerfelNumb = 1;
var gamersPos = [];
actionTime = Date.now();
actionId = 0;
done = true;
lastSend = "";
sendDataToAddon();
getAction();

function sendDataToAddon()
{
        //gamersPos
        if(gamers.length != NaN)
        {
            for(i=0;i&lt;gamers.length;i++)
            {
                pos = i + 1;
                gamersPos[i] = {pos: $("#yolo td .spieler"+pos).parent().attr("rel")*1, username: gamers[i]};
            }
        }
        else
        {
            gamersPos = null;
        }
    if(lastSend == "" || (lastSend.number != wuerfelNumb || lastSend.gameTask != $('#gameWhat').text() || lastSend.player != $('b.dran').text().slice(0,-2) || lastSend.gameId != gameId || lastSend.additionalTask != $('#ereignis').text()))
    {
        lastSend = { number: wuerfelNumb, gameTask: $('#gameWhat').text(), player: $('b.dran').text().slice(0,-2), gameId: gameId, gamersPos: gamersPos, additionalTask: $('#ereignis').text()};
        //send data
        $.ajax({
            method: "POST",
            url: "https://pdg.jaksmakowalo.pl/recive_data.php",
            data: { number: wuerfelNumb, gameTask: $('#gameWhat').text(), player: $('b.dran').text().slice(0,-2), gameId: gameId, gamersPos: gamersPos, additionalTask: $('#ereignis').text()}
        })
            .done(function( msg ) {
                setTimeout(getAction(), 1000);
            });
    }
    else
    {
        setTimeout(getAction(), 1000);
    }

}

function getAction()
{
    $.ajax({
        method: "POST",
        url: "https://pdg.jaksmakowalo.pl/getAction.php",
        data: {actionTime: actionTime, id: actionId, done: done, gameId: gameId}
    })
        .done(function( msg ) {
            if(msg.new == true)
            {
                actionId = msg.actionId;
                actionTime = msg.created_at;
                done = msg.done;
                actionName = msg.name;
                if(actionName == "clickDice" && done == false)
                {
                    $('#wuerfel').trigger('click');
                    done = true;
                }
                else if(done == false)
                {
                    $('input[value="'+ actionName +'"]').trigger('click');
                    done = true;
                }
            }
            sendDataToAddon();
        });
}