/**
 * External dependencies
 */
import { store } from 'react-notifications-component';
import type { ReactNotificationOptions } from 'react-notifications-component';

type ReactAddNotificationProps = {
	message: string;
	type: ReactNotificationOptions[ 'type' ];
	duration?: number;
};

export const addNotification = ( {
	message,
	type,
	duration = 2000,
}: ReactAddNotificationProps ) => {
	const options: ReactNotificationOptions = {
		message,
		type,
		animationIn: [ 'bounce-in' ],
		insert: 'bottom',
		container: 'top-center',
		dismiss: {
			duration,
			showIcon: true,
		},
	};
	store.addNotification( options );
};
