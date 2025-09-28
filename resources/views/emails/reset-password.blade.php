@component('mail::message')
# 🔐 Redefinição de Senha

Olá, {{ $notifiable->name ?? 'usuário' }} 👋

Recebemos um pedido para redefinir a senha da sua conta **e-Vacina**.
Para continuar, clique no botão abaixo:

@component('mail::button', ['url' => $url, 'color' => 'primary'])
🔑 Redefinir Senha
@endcomponent

⏳ Este link é válido por **60 minutos**.
Após esse prazo, será necessário solicitar uma nova redefinição.

⚠️ Se você **não solicitou essa alteração**, basta ignorar este e-mail.
Sua senha atual permanecerá segura.

---

Atenciosamente,
**Equipe {{ config('app.name') }}**
@endcomponent
