{extends file="system/page.tpl"}

{block name=pageBody}
    <div class="ui middle aligned center aligned grid" style="height: 100%">
        <div class="column" style=" max-width: 450px;">
            <h2 class="ui blue header">
                <div class="content">
                    Log-in to your account
                </div>
            </h2>
            <form class="ui large form">
                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" id="email" name="email" placeholder="E-mail address">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="ui fluid large blue submit button">Login</div>
                </div>
                <div class="ui error message"></div>
            </form>
        </div>
    </div>
    <script>
        {literal}
            $(document).ready(function () {
                $('.ui.form').form({
                    fields: {
                        email: {
                            identifier: 'email',
                            rules: [{
                                    type: 'empty',
                                    prompt: 'Please enter your e-mail'
                                }, {
                                    type: 'email',
                                    prompt: 'Please enter a valid e-mail'
                                }]
                        },
                        password: {
                            identifier: 'password',
                            rules: [{
                                    type: 'empty',
                                    prompt: 'Please enter your password'
                                }, {
                                    type: 'length[6]',
                                    prompt: 'Your password must be at least 6 characters'
                                }]
                        }
                    }
                });
                $('form.ui.form').submit(function (e) {
                    e.preventDefault();
                    if ($('.ui.form').form('is valid')) {
                        var username = $('#email').val();
                        var password = $('#password').val();
                        $.ajax({
                            url: '/v2/auth/login',
                            dataType: 'json',
                            type: 'POST',
                            data: {
                                username: username,
                                password: password
                            },
                            success: function (data) {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            }
                        });
                    }
                });
            });
        {/literal}
    </script>
{/block}
