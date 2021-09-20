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
</style>

<body>
    <div>
        <h2>Whoops!</h2>
        <p><?php echo $e->getMessage() ?></p>
    </div>
</body>

</html>