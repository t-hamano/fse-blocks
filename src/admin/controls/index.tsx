/**
 * External dependencies
 */
import type { ReactNotificationOptions } from 'react-notifications-component';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import { useState } from '@wordpress/element';
import { Button, Modal } from '@wordpress/components';

/**
 * Internal dependencies
 */
import { addNotification } from '../helper';
import type { AdminOptionProps, ChildProps } from '../';

export interface ApiResponse {
	type?: ReactNotificationOptions[ 'type' ];
	message?: string;
	options?: AdminOptionProps;
}

const EditorConfig = ( props: ChildProps ) => {
	const { options, setOptions, isWaiting, setIsWaiting } = props;
	const [ isModalOpen, setIsModalOpen ] = useState( false );

	// Update options.
	const handleUpdateOptions = () => {
		setIsWaiting( true );

		apiFetch< ApiResponse >( {
			path: '/fseb/v1/option',
			method: 'POST',
			data: options,
		} ).then( ( response ) => {
			const { message, type } = response;

			setTimeout( () => {
				if ( message && type ) {
					addNotification( { message, type } );
				}
				setIsWaiting( false );
			}, 600 );
		} );
	};

	// Reset options.
	const handleResetOptions = () => {
		setIsWaiting( true );

		apiFetch< ApiResponse >( {
			path: '/fseb/v1/option',
			method: 'DELETE',
		} ).then( ( response ) => {
			const { message, type, options: newOptions } = response;

			setTimeout( () => {
				if ( message && type && newOptions ) {
					setOptions( newOptions );
					addNotification( { message, type } );
				} else {
					addNotification( {
						message: __( 'An error has occurred.', 'fse-blocks' ),
						type: 'danger',
					} );
				}
				setIsWaiting( false );
			}, 600 );
		} );
	};

	return (
		<>
			<ul className="fseb-controls">
				<li className="fseb-controls__item">
					<Button
						className="fseb-controls__submit"
						isPrimary
						disabled={ isWaiting }
						onClick={ handleUpdateOptions }
					>
						{ __( 'Save Settings', 'fse-blocks' ) }
					</Button>
				</li>
				<li className="fseb-controls__item">
					<Button
						className="fseb-controls__reset"
						isSecondary
						disabled={ isWaiting }
						onClick={ () => setIsModalOpen( true ) }
					>
						{ __( 'Reset' ) }
					</Button>
				</li>
			</ul>
			{ isModalOpen && (
				<Modal
					title={ __( 'Reset Settings', 'fse-blocks' ) }
					className="fseb-modal"
					onRequestClose={ () => setIsModalOpen( false ) }
				>
					<p>{ __( 'Are you sure that reset all settings to default values ?', 'fse-blocks' ) }</p>
					<div className="fseb-modal__controls">
						<Button
							isDestructive
							onClick={ () => {
								handleResetOptions();
								setIsModalOpen( false );
							} }
						>
							{ __( 'Reset Settings', 'fse-blocks' ) }
						</Button>
						<Button isSecondary onClick={ () => setIsModalOpen( false ) }>
							{ __( 'Cancel', 'fse-blocks' ) }
						</Button>
					</div>
				</Modal>
			) }
		</>
	);
};

export default EditorConfig;
