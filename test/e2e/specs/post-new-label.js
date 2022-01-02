/**
 * WordPress dependencies
 */
import {
	getEditedPostContent,
	createNewPost,
} from '@wordpress/e2e-test-utils';

describe( 'New Post Label', () => {
	beforeEach( async () => {
		await createNewPost();
	} );

	it( 'should create block', async () => {
		await insertBlock( 'post-new-label' );
		expect( await getEditedPostContent() ).toMatchSnapshot();
	} );
} );
