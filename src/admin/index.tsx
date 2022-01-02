/**
 * External dependencies
 */
import ReactNotification from 'react-notifications-component';
import classnames from 'classnames';
import type { Dispatch, SetStateAction } from 'react';

/**
 * WordPress dependencies
 */
import { __, sprintf } from '@wordpress/i18n';
import domReady from '@wordpress/dom-ready';
import { TabPanel, Spinner } from '@wordpress/components';
import { render, useState } from '@wordpress/element';

/**
 * Internal dependencies
 */
import './style.scss';
import TestSetting from './test';
import PostNewLabelSetting from './post-new-label';
import Controls from './controls';

export interface AdminOptionProps {
	// eslint-disable-next-line camelcase
	post_new_label: {
		test: boolean;
	};
	test: {
		test: boolean;
	};
}

interface WindowProps extends Window {
	fsebObj: {
		options: AdminOptionProps;
		version: string;
	};
}
declare const window: WindowProps;

export interface ChildProps {
	isWaiting: boolean;
	setIsWaiting: Dispatch< SetStateAction< boolean > >;
	options: AdminOptionProps;
	setOptions: Dispatch< SetStateAction< AdminOptionProps > >;
}

const Admin = () => {
	const [ isWaiting, setIsWaiting ] = useState< boolean >( false );
	const [ options, setOptions ] = useState< AdminOptionProps >( window.fsebObj.options );

	const childProps = {
		isWaiting,
		setIsWaiting,
		options,
		setOptions,
	};

	return (
		<>
			{ isWaiting && (
				<div className="fseb-loading">
					<Spinner />
				</div>
			) }
			<div className={ classnames( 'fseb-wrap', { 'fseb-wrap--is-waiting': isWaiting } ) }>
				<ReactNotification />
				<header className="fseb-header">
					<div className="fseb-container">
						<h1 className="fseb-header__ttl">{ __( 'FSE Blocks', 'fse-blocks' ) }</h1>
						<p className="fseb-header__version">
							{ sprintf(
								/* translators: %d is replaced with the number of version. */
								__( 'Version: %s', 'fse-blocks' ),
								window.fsebObj.version
							) }
						</p>
					</div>
				</header>
				<TabPanel
					className="fseb-tabs"
					tabs={ [
						{
							name: 'post-new-label',
							title: __( 'NewPost Label', 'fse-blocks' ),
						},
						{
							name: 'test',
							title: __( 'Test', 'fse-blocks' ),
						},
					] }
				>
					{ ( tab ) => (
						<div className="fseb-container">
							<div className="fseb-tab-content">
								{ 'post-new-label' === tab.name && <PostNewLabelSetting { ...childProps } /> }
								{ 'test' === tab.name && <TestSetting { ...childProps } /> }
							</div>
						</div>
					) }
				</TabPanel>
				<div className="fseb-container">
					<Controls { ...childProps } />
				</div>
			</div>
		</>
	);
};

domReady( function () {
	render( <Admin />, document.getElementById( 'fse-blocks-admin' ) );
} );
