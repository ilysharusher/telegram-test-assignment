<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linking Trello</title>
    <script>
        window.onload = function () {
            const params = new URLSearchParams(window.location.hash.substring(1));
            const token = params.get("token");
            if (token) {
                window.location.href = "{{ url('/trello/callback') }}?user_id={{ $userId }}&token=" + token;
            } else {
                document.body.innerHTML = "<h2>Failed to extract token.</h2>";
            }
        };
    </script>
</head>
<body>
<h2>Linking your Trello account...</h2>
</body>
</html>
