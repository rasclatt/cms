<html>
<style>
    * {
        box-sizing: border-box;
        font-family: Arial;
        text-align: center;
    }

    body,
    html {
        padding: 0;
        margin: 0;
        height: 100vh;
        width: 100vw;
        background-color: #222;
        color: #FFF;
    }

    body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        align-items: center;
    }
    .error-msg {
        background-color: #333;
        border-radius: 5px;
        box-shadow: 2px 2px 10px #000;
        padding: 2em;
    }
</style>

<body>
    <div class="m-4 error-msg">
        <h2>Whoops!</h2>
        <p><?php echo ($e)?? \Nubersoft\nApp::call()->getDataNode('_MESSAGES')['msg'] ?></p>
    </div>
</body>

</html>