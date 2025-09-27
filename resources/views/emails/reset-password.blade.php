@component('mail::message')
# 🔐 Redefinição de Senha

Olá, {{ $notifiable->name ?? 'usuário' }}!

Recebemos uma solicitação para redefinir a senha da sua conta **eVacina**.

@component('mail::button', ['url' => $url, 'color' => 'success'])
👉 Redefinir Minha Senha
@endcomponent

⚠️ Este link expira em **60 minutos**.

Se você **não fez essa solicitação**, pode ignorar este e-mail com segurança.

---

Obrigado,<br>
Equipe {{ config('app.name') }}

@endcomponent
