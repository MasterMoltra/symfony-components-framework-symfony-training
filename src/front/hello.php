Hello <?php
        echo htmlspecialchars(
            $request->get('name', 'World'),
            ENT_QUOTES,
            'UTF-8'
        );
