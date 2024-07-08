<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
</head>


<body>
    <section class="h-screen">
        <div class="h-full">
            <!-- Left column container with background-->
            <div class="flex h-full flex-wrap items-center justify-center">
                <div class="mb-12 md:mb-0 md:w-8/12 lg:w-5/12 xl:w-5/12">
                    <form method="POST" id="login_form">
                        <!--Sign in section-->
                        <div class="flex flex-row items-center justify-center lg:justify-start">
                            <p class="mb-0 me-4 text-lg">Sign in</p>


                        </div>

                        <!-- Separator between social media sign in and email/password sign in -->
                        <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-neutral-300 after:mt-0.5 after:flex-1 after:border-t after:border-neutral-300 dark:before:border-neutral-500 dark:after:border-neutral-500">

                        </div>

                        <!-- Username input -->
                        <div class="relative mb-6" data-twe-input-wrapper-init>
                            <label for="username_input">Username
                            </label>
                            <input type="text" class=" peer block min-h-[auto] w-full rounded border bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-white dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill dark:peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0" id="username_input" name="username_input" placeholder="Email address" />

                        </div>

                        <!-- Password input -->
                        <div class="relative mb-6" data-twe-input-wrapper-init>
                            <label for="password_input">Password
                            </label>
                            <input type="password" class="peer block min-h-[auto] w-full rounded border bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[twe-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-white dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill dark:peer-focus:text-primary [&:not([data-twe-input-placeholder-active])]:placeholder:opacity-0" id="password_input" name="password_input" placeholder="Password" />

                        </div>


                        <!-- Login button -->
                        <div class="text-center lg:text-left">
                            <button type="submit" class="mb-6 inline-block w-full rounded bg-blue-700 px-7 pb-2 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-blue-800 hover:shadow-blue-50 focus:bg-blue-900 focus:shadow-blue-50 focus:outline-none focus:ring-0 active:bg-blue-900 active:shadow-blue-50 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-black" data-twe-ripple-init data-twe-ripple-color="light">
                                Login
                            </button>


                            <a href="#!" class="font-semibold  text-danger transition duration-150 ease-in-out hover:text-danger-600 focus:text-danger-600 active:text-danger-700">
                                < Go Back</a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('login_form').addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username_input').value;
            const password = document.getElementById('password_input').value;
            if (username === "" || password === "") {
                alert("fill both input username and password");
                return;
            }
            $.ajax({
                type: "POST",
                url: "login_process",

                data: {
                    username: username,
                    password: password
                },
                success: function(response) {
                    console.log(response);

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Login Success",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        window.location.href = "index"
                    });



                },
                error: function(response) {
                    console.error(response);
                    alert("Fail log in: " + response);
                },
            });
        });
    </script>
</body>

</html>