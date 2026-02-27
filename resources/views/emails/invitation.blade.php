<div style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 40px; color: #1d1d1f; line-height: 1.5;">
    <div style="max-width: 500px; margin: 0 auto; background: #ffffff; border-radius: 24px; padding: 32px; border: 1px solid #f5f5f7;">
        <h2 style="font-size: 24px; font-weight: 900; letter-spacing: -0.05em; margin-bottom: 24px; font-style: italic; text-transform: uppercase;">Bonjour !</h2>
        
        <p style="font-size: 14px; font-weight: 500; color: #86868b; margin-bottom: 32px; font-style: italic;">
            Vous avez été invité à rejoindre la colocation 
            <strong style="color: #1d1d1f; text-transform: uppercase;">{{ $colocation->name }}</strong>.
        </p>

        <a href="{{ route('register', ['email' => $email ?? '']) }}" 
           style="display: block; background: #000000; color: #ffffff; padding: 18px; text-decoration: none; border-radius: 16px; font-weight: bold; text-align: center; font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; font-style: italic;">
            Créer mon compte et rejoindre
        </a>

        <p style="font-size: 10px; color: #86868b; margin-top: 24px; text-align: center; font-style: italic;">
            Une fois inscrit, vous pourrez accepter l'invitation sur votre Dashboard.
        </p>
    </div>
</div>