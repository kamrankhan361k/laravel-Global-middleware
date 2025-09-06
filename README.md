# 📝 Laravel One-Time Form Submission (with Middleware)

This is a simple **Laravel project** that demonstrates how to use **Middleware** to restrict a form so it can only be submitted **once**.  
If the form is already filled, the user cannot go back and fill it again — they will see an "Already Filled" message.

---

## 🚀 Features
- Laravel 10 project
- Blade-based form view
- Middleware (`CheckFormFilled`) to restrict multiple submissions
- Controller for handling form logic
- Validation with unique email
- Stores data in MySQL database
- Simple UI with **form → thank you → already filled**

---

## ⚙️ Installation

1. Clone the repo or create a fresh Laravel project:
   ```bash
   composer create-project laravel/laravel one-time-form
   cd one-time-form
   ```

2. Configure your `.env` file with database credentials.

3. Run migration to create table:
   ```bash
   php artisan migrate
   ```

4. Serve the project:
   ```bash
   php artisan serve
   ```

5. Open in browser:
   ```
   http://127.0.0.1:8000
   ```

---

## 🗂️ Project Structure

```
app/
 ├── Http/
 │    ├── Controllers/
 │    │     └── FormController.php
 │    ├── Middleware/
 │    │     └── CheckFormFilled.php
database/
 └── migrations/
      └── create_user_forms_table.php
resources/
 └── views/
      ├── form.blade.php
      ├── thankyou.blade.php
      └── already-filled.blade.php
routes/
 └── web.php
```

---

## 🔑 Core Logic

### 1. Form Controller
Handles showing, validating, and saving the form.

```php
public function submitForm(Request $request)
{
    $request->validate([
        'name'  => 'required',
        'email' => 'required|email|unique:user_forms,email',
    ]);

    UserForm::create($request->only('name', 'email'));

    session(['email' => $request->email]);

    return redirect()->route('form.thankyou');
}
```

### 2. Middleware (`CheckFormFilled`)
Prevents users from accessing the form if they already submitted it.

```php
public function handle(Request $request, Closure $next)
{
    if (session()->has('email')) {
        $email = session('email');

        if (UserForm::where('email', $email)->exists()) {
            return response()->view('already-filled');
        }
    }

    return $next($request);
}
```

### 3. Routes
Apply middleware only to the form route.

```php
Route::get('/', [FormController::class, 'showForm'])
    ->middleware('check.form')
    ->name('form.show');
```

---

## 🌍 What is Global Middleware?

- **Global Middleware** runs on **every request** in your Laravel app.
  - Example: Adding security headers, logging, forcing HTTPS, trimming strings.
  - Registered in `app/Http/Kernel.php` under `$middleware`.

Example:
```php
protected $middleware = [
    \App\Http\Middleware\AddGlobalHeader::class,
];
```

- **Route Middleware** runs only on **specific routes** when applied.
  - In this project, we used `check.form` only for `/` route so the form can’t be refilled.

---

## ✅ Demo Flow

1. Visit `/` → Fill form → Submit  
2. Redirects to **Thank You** page  
3. Try going back to `/` → You’ll see **Already Filled** page  
4. Prevents duplicate submissions 🎉

---

## 📌 Notes
- This project uses **session + DB check** to restrict access.  
- You can upgrade it to **per-authenticated user** by replacing session with `Auth::user()->id`.

---
