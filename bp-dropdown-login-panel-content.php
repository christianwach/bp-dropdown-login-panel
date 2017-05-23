<?php

/**
 * Show HTML Header.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_header() {

	// set a class for the panel
	$class = ' class="bsl-anon"';

	// when logged in
	if ( is_user_logged_in() ) {

		// override a class for the panel
		$class = ' class="bsl-logged-in"';

	}

	?>

	<div id="bp-dropdown-login-wrapper">

		<div id="bp-dropdown-login-panel"<?php echo $class; ?>>

			<div class="content clearfix">

				<?php if ( is_user_logged_in() ) {

					// show user header
					bp_dropdown_login_panel_show_header_user();

				} else {

					// show anon header
					bp_dropdown_login_panel_show_header_anon();

				} ?>

			</div><!-- /.content -->

		</div><!-- /#bp-dropdown-login-panel -->

		<?php if ( is_user_logged_in() ) {

			// show logout
			bp_dropdown_login_panel_show_logout();

		} else {

			// show login
			bp_dropdown_login_panel_show_login();

		} ?>

	</div><!-- /#bp-dropdown-login-wrapper -->

	<?php

} // end bp_dropdown_login_panel_show_header



/**
 * Show HTML Header for Logged In users.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_header_user() {

	// access BP global
	global $bp;

	// get logo, but allow overrides
	$logo_image = apply_filters(
		'bp_dropdown_login_logo',
		plugins_url( 'assets/images/logo.png', BP_DROPDOWN_LOGIN_FILE )
	);

	?>
	<div class="bp-dropdown-login-left bsl-header bsl-border">

		<img src="<?php echo $logo_image; ?>"  alt="<?php _e( 'Logo', 'bp-dropdown-login-panel' ); ?>" />

		<h2><?php echo sprintf( __( 'Welcome back, %s', 'bp-dropdown-login-panel' ), bp_core_get_user_displayname( bp_loggedin_user_id() ) ); ?></h2>

		<h2 class="bp-dropdown-login-messages-header"><?php _e( 'My Messages', 'buddypress' ) ; ?></h2>

		<div class="bp-dropdown-login-msgs">

			<?php if ( bp_has_message_threads( 'per_page=2' ) ) : ?>

				<ul id="message-threads">

					<?php while ( bp_message_threads() ) : bp_message_thread(); ?>

						<li<?php if ( bp_message_thread_has_unread() ) : ?> class="bp-dropdown-login-unread"<?php else: ?> class="bp-dropdown-login-read"<?php endif; ?>>

							<div class="bp-dropdown-login-message-subject">
								<?php bp_message_thread_avatar('type=full&width=35&height=35') ?>
								<?php bp_message_thread_subject() ?>
							 </div>

							<div class="bp-dropdown-login-message-meta">
								<p><a class="button view" title="<?php _e( 'View Message' , 'buddypress' ); ?>" href="<?php bp_message_thread_view_link() ?>"><?php _e( 'View Message' , 'buddypress' ); ?></a> <a class="button view" title="<?php _e( 'Send Reply' , 'buddypress' ); ?>" href="<?php bp_message_thread_view_link() ?>/#send-reply"><?php _e( 'Reply' , 'buddypress' ); ?></a></p>
							</div>

						</li>

					<?php endwhile; ?>

				</ul>

			<?php else: ?>

				<div>
					<p class="bp-dropdown-login-msg"><img src="<?php echo plugins_url( 'assets/images/msg.png', BP_DROPDOWN_LOGIN_FILE ); ?>"  alt="<?php _e( 'Messages' , 'buddypress' ); ?>" class="bp-dropdown-login-msg" /> <?php _e( 'You have 0 new messages.' , 'bp-dropdown-login-panel' ); ?></p>
				</div>

			<?php endif;?>

		</div><!-- /#message-threads -->

	</div><!-- /.left.bsl-border -->



	<?php do_action( 'bp_dropdown_login_panel_user_after_header' ); ?>



	<div class="bp-dropdown-login-left bsl-avatar bsl-narrow">

		<h2><?php _e( 'My Avatar' , 'bp-dropdown-login-panel' ); ?></h2>

		<a class="bp-dropdown-login-avatar" href="<?php echo trailingslashit( bp_loggedin_user_domain() . $bp->profile->slug ); ?>"><?php
			bp_loggedin_user_avatar( 'type=full&width=117&height=117' )
		?></a>

		<a href="<?php echo trailingslashit( bp_loggedin_user_domain() . $bp->profile->slug . '/change-avatar' ); ?>"><?php
			_e( 'Change Avatar' , 'buddypress' );
		?> &rarr;</a>

	</div><!-- /.left.bsl-narrow -->



	<div class="bp-dropdown-login-left bsl-profile bsl-narrow">

		<h2><?php _e( 'Profile' , 'buddypress' ); ?></h2>

		<ul>
			<li><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . $bp->profile->slug ); ?>"><?php
				_e( 'View My Profile' , 'bp-dropdown-login-panel' );
			?></a></li>
			<li><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . $bp->profile->slug . '/edit' ); ?>"><?php
				_e( 'Edit My Profile' , 'buddypress' );
			?></a></li>
			<li><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . $bp->profile->slug . '/change-avatar' ); ?>"><?php
				_e( 'Change Avatar' , 'buddypress' );
			?></a></li>
			<li><a href="<?php echo wp_logout_url( get_permalink() ); ?>" rel="nofollow" title="<?php
				_e( 'Log out' );
			?>"><?php _e( 'Log out' ); ?></a></li>
		</ul>

		<h2><?php _e( 'Activity', 'buddypress' ); ?></h2>

		<ul>
			<li><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_activity_slug() ); ?>"><?php
				_e( 'Update My Status', 'bp-dropdown-login-panel' );
			?></a></li>
			<li><a href="<?php bp_activity_directory_permalink(); ?>"><?php
				_e( 'Sitewide Activity', 'bp-dropdown-login-panel' );
			?></a></li>
		</ul>

	</div><!-- /.left.bsl-narrow -->



	<div class="bp-dropdown-login-left bsl-mentions bsl-narrow">

		<h2><?php _e( 'Mentions', 'buddypress' ); ?></h2>

		<a href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_activity_slug() . '/mentions' ); ?>" title="<?php esc_attr_e( 'Activity that I have been mentioned in.', 'bp-dropdown-login-panel' ); ?>"><?php
			printf( __( '@%s Mentions', 'bp-dropdown-login-panel' ), bp_get_loggedin_user_username() );
		?></a>

		<h2><?php _e( 'Groups', 'buddypress' ); ?></h2>

		<ul>
			<li><a href="<?php bp_groups_directory_permalink(); ?>"><?php
				_e( 'Groups Directory', 'buddypress' );
			?></a></li>
			<li><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups' ); ?>"><?php
				_e( 'My Groups', 'bp-dropdown-login-panel' );
			?></a></li>
			<li><a href="<?php echo trailingslashit( bp_get_groups_directory_permalink() . 'create' ); ?>"><?php
				_e( 'Create a Group', 'buddypress' );
			?></a></li>
		</ul>

	</div><!-- /.left.bsl-narrow -->



	<?php if ( bp_is_active( 'friends' ) ) { ?>

	<div class="bp-dropdown-login-left bsl-friends bsl-narrow">

		<h2><?php _e( 'Friends', 'bp-dropdown-login-panel' ); ?></h2>

		<ul>
			<li><a href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends' ); ?>"><?php
				_e( 'My Friends', 'buddypress' );
			?></a></li>
			<li><a href="<?php bp_members_directory_permalink(); ?>"><?php
				_e( 'Meet Friends', 'bp-dropdown-login-panel' );
			?></a></li>
		</ul>

		<h2><?php _e( 'Friend Requests', 'bp-dropdown-login-panel' ); ?></h2>

		<?php do_action( 'bp_before_member_friend_requests_content' ) ?>

		<?php if ( bp_has_members( 'max=1&type=alphabetical&include=' . bp_get_friendship_requests( bp_loggedin_user_id() ) ) ) : ?>

			<ul id="friend-list" class="item-list">

				<?php while ( bp_members() ) : bp_the_member(); ?>

					<div>
						<p><a href="<?php bp_member_link() ?>"><?php bp_member_avatar( 'width=20&height=20' ) ?></a> <a href="<?php bp_member_link() ?>"><?php bp_member_name() ?></a></p>
					</div>

					<?php do_action( 'bp_friend_requests_item' ) ?>

					<div class="action">
						<a class="bp-dropdown-login-accept" href="<?php bp_friend_accept_request_link() ?>"><?php
							_e( 'Accept', 'buddypress' );
						?></a> | <a class="bp-dropdown-login-reject" href="<?php bp_friend_reject_request_link() ?>"><?php
							_e( 'Reject', 'buddypress' );
						?></a>
						<?php do_action( 'bp_friend_requests_item_action' ) ?>
						<p><a id="whitetext" href="<?php echo trailingslashit( bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests' ); ?>"><?php _e( 'More' ); ?> &rarr;</a></p>
					</div>


				<?php endwhile; ?>

			</ul>

			<?php do_action( 'bp_friend_requests_content' ) ?>

		<?php else : ?>

			<div>
				<p><?php _e( 'You have no pending friendship requests.', 'buddypress' ); ?></p>
			</div>

		<?php endif;?>

		<?php do_action( 'bp_after_member_friend_requests_content' ) ?>

	</div><!-- /.left.bsl-narrow -->

	<?php } ?>



	<?php

} // end bp_dropdown_login_panel_show_header_user



/**
 * Show HTML Header for Anonymous users.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_header_anon() {

	// get logo, but allow overrides
	$logo_image = apply_filters(
		'bp_dropdown_login_logo',
		plugins_url( 'assets/images/logo.png', BP_DROPDOWN_LOGIN_FILE )
	);

	?>

	<div class="bp-dropdown-login-left bsl-header bsl-border">

		<img src="<?php echo $logo_image; ?>"  alt="<?php _e( 'Logo', 'bp-dropdown-login-panel' ); ?>" />

		<h2><?php

		echo sprintf(
			__( 'Welcome to %s', 'bp-dropdown-login-panel' ),
			get_bloginfo( 'name' )
		);

		?></h2>

		<p><?php

		echo apply_filters(
			'bp_dropdown_login_panel_anon_intro',
			__( "Login or Signup to meet new friends, find out what's going on, and connect with others on the site.", 'bp-dropdown-login-panel' )
		);

		?></p>

	</div><!-- /.left.bsl-border -->



	<?php do_action( 'bp_dropdown_login_panel_anon_after_header' ); ?>

	<?php bp_dropdown_login_panel_show_register(); ?>

	<?php do_action( 'bp_dropdown_login_panel_anon_after_register' ); ?>

	<?php bp_dropdown_login_panel_show_forgot(); ?>

	<?php do_action( 'bp_dropdown_login_panel_anon_after_forgot' ); ?>

	<?php

} // end bp_dropdown_login_panel_show_header_user()



/**
 * Show Register Panel.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_register() {

	?>

		<?php if ( bp_get_signup_allowed() ) : ?>

			<div class="bp-dropdown-login-left bsl-register">

				<!-- Register Form -->
				<form name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">

					<h2><?php _e( 'Create an Account', 'buddypress' ); ?></h2>
					<?php _e( 'Registering for this site is easy. Just fill in the fields below, and we\'ll get a new account set up for you in no time.', 'buddypress' ); ?><br/>
					<input type="submit" name="wp-submit" id="wp-submit" value="<?php _e( 'Register', 'buddypress' ); ?>" class="bp-dropdown-login-button" />

				</form>

			</div><!-- /.left -->

		<?php else : ?>

			<div class="bp-dropdown-login-left bsl-register bsl-register-closed">

				<h2><?php _e( 'Registration', 'buddypress' ); ?></h2>
				<p><?php _e( 'Sorry, you are not allowed to register by yourself on this site.', 'bp-dropdown-login-panel' ); ?></p>
				<p><?php _e( 'You must either be invited by one of our team members or request an invitation by email.', 'bp-dropdown-login-panel' ); ?></p>

			</div><!-- /.left -->

		<?php endif ?>



	<?php

} // end bp_dropdown_login_panel_show_register



/**
 * Show Login Form Panel.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_login_form() {

	?>

	<div class="bp-dropdown-login-left bsl-login-form">

		<form name="bp-login-form" id="bp-login-widget-form" class="standard-form" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">

			<h2><?php _e( 'Log In' ); ?></h2>

			<label for="bp-login-widget-user-login"><?php _e( 'Username' ); ?></label>
			<input type="text" name="log" id="bp-login-widget-user-login" class="input" value="" />

			<label for="bp-login-widget-user-pass"><?php _e( 'Password' ); ?></label>
			<input type="password" name="pwd" id="bp-login-widget-user-pass" class="input" value=""  />

			<div class="forgetmenot"><label><input name="rememberme" type="checkbox" id="bp-login-widget-rememberme" value="forever" /> <?php _e( 'Remember Me' ); ?></label></div>

			<input type="submit" name="wp-submit" id="bp-login-widget-submit" value="<?php esc_attr_e( 'Log In' ); ?>" />

		</form>
	</div><!-- /.left.right -->



	<?php

} // end bp_dropdown_login_panel_show_login_form



/**
 * Show Forgot Password Panel.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_forgot() {

	$class = '';
	if ( ! bp_get_signup_allowed() ) {
		$class = ' bsl-register-closed';
	}

	?>

	<div class="bp-dropdown-login-left bsl-forgot<?php echo $class; ?>">

		<form class="clearfix" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">

			<h2><?php _e( 'Lost your password?' ); ?></h2>
			<label class="bp-dropdown-login-grey" for="user_login"><?php _e( 'Username or E-mail:' ); ?></label>
			<input class="field bp-dropdown-login-field" type="text" name="user_login" id="user_login_FP" value="" size="23" />
			<div class="clear"></div>
			<p><?php _e( 'Please enter your username or email address. You will receive a link to create a new password via email.' ); ?></p>
			<input type="submit" name="submit" value="<?php _e( 'Get New Password' ); ?>" class="bp-dropdown-login-button" />
			<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>

		</form>

	</div><!-- /.left.right -->



	<?php

} // end bp_dropdown_login_panel_show_forgot



/**
 * Show Login Panel.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_login() {

	?>

	<!-- The tab on top -->
	<div class="bp-dropdown-login-tab">

		<ul class="bp-dropdown-login-login">
			<li class="bp-dropdown-login-left">&nbsp;</li>
			<!-- Login / Register -->
			<li id="bp-dropdown-login-toggle">
				<a id="bp-dropdown-login-open" class="bp-dropdown-login-open" href="#"><?php
					_e( 'Log In' );
				?></a>
				<a id="bp-dropdown-login-close" style="display: none;" class="bp-dropdown-login-close" href="#"><?php
					_e( 'Close Panel', 'bp-dropdown-login-panel' );
				?></a>
			</li>
			<li class="bp-dropdown-login-right">&nbsp;</li>
		</ul>

	</div> <!-- /.bp-dropdown-login-tab -->



	<?php

} // end bp_dropdown_login_panel_show_login



/**
 * Show Logout Panel.
 *
 * @since 3.0
 */
function bp_dropdown_login_panel_show_logout() {

	?>

	<!-- The tab on top -->
	<div class="bp-dropdown-login-tab">

		<ul class="bp-dropdown-login-login">
			<li class="bp-dropdown-login-left">&nbsp;</li>
			<!-- Logout -->
			<!--<li><a class="bp-dropdown-login-logout" href="<?php echo wp_logout_url( get_permalink() ); ?>" rel="nofollow" title="<?php _e( 'Log out' ); ?>"><?php _e( 'Log out' ); ?></a></li>
			<li class="bp-dropdown-login-sep">|</li>-->
			<li id="bp-dropdown-login-toggle">
				<a id="bp-dropdown-login-open" class="bp-dropdown-login-open" href="#"><?php
					_e( 'My Account', 'buddypress' );
				?></a>
				<a id="bp-dropdown-login-close" style="display: none;" class="bp-dropdown-login-close" href="#"><?php
					_e( 'Close Panel', 'bp-dropdown-login-panel' );
				?></a>
			</li>
			<li class="bp-dropdown-login-right">&nbsp;</li>
		</ul>

	</div><!-- /.tab -->



	<?php

} // end bp_dropdown_login_panel_show_logout



