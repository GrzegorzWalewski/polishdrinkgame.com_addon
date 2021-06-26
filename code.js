wuerfelNumb = 1;
var gamersPos = [];
actionTime = Date.now();
actionId = 0;
done = true;
sendDataToAddon();

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
    //send data
    $.ajax({
        method: "POST",
        url: "https://pdg.jaksmakowalo.pl/recive_data.php",
        data: { number: wuerfelNumb, gameTask: $('#gameWhat').text(), player: $('b.dran').text().slice(0,-2), gameId: gameId, gamersPos: gamersPos, additionalTask: $('#ereignis').text()}
    })
        .done(function( msg ) {
            getAction();
        });
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
            }
            sendDataToAddon();
        });
}