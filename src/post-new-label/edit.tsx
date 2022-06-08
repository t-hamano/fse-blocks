/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
// @ts-ignore: has no exported member
import { getDate, format, __experimentalGetSettings as getSettings } from '@wordpress/date';
import {
	AlignmentToolbar,
	InspectorControls,
	// @ts-ignore: has no exported member
	JustifyContentControl,
	BlockControls,
	useBlockProps,
	// @ts-ignore: has no exported member
	__experimentalUseBorderProps as useBorderProps,
	// @ts-ignore: has no exported member
	__experimentalUseColorProps as useColorProps,
	// @ts-ignore: has no exported member
	__experimentalGetSpacingClassesAndStyles as useSpacingProps,
	// @ts-ignore: has no exported member
	__experimentalUnitControl as UnitControl,
	RichText,
} from '@wordpress/block-editor';
// @ts-ignore: has no exported member
import { useEntityProp } from '@wordpress/core-data';
import {
	Button,
	ButtonGroup,
	PanelBody,
	BaseControl,
	RangeControl,
	// @ts-ignore: has no exported member
	__experimentalUseCustomUnits as useCustomUnits,
} from '@wordpress/components';
// @ts-ignore: has no exported member
import { useInstanceId } from '@wordpress/compose';
import type { BlockEditProps } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import './editor.scss';
import {
	DEFAULT_WIDTH_PC,
	DEFAULT_WIDTH_PX,
	DEFAULT_WIDTH_EM,
	MIN_WIDTH,
	MIN_WIDTH_UNIT,
	MIN_DAY,
	MAX_DAY,
} from './constants';
import type { BlockAttributes } from './BlockAttributes';

interface Props extends BlockEditProps< BlockAttributes > {
	readonly context: any;
}

export default function Edit( props: Props ) {
	const { attributes, setAttributes, context } = props;
	const { contentJustification, day, label, textAlign, width, widthUnit } = attributes;
	const { postType, postId, queryId } = context;

	const isDescendentOfQueryLoop = !! queryId;

	const unitControlInstanceId = useInstanceId( UnitControl );
	const unitControlInputId = `.wp-block-fse-blocks-post-new-label__width-${ unitControlInstanceId }`;

	const units = useCustomUnits( {
		availableUnits: [ '%', 'px', 'em' ],
		defaultValues: {
			'%': DEFAULT_WIDTH_PC,
			px: DEFAULT_WIDTH_PX,
			em: DEFAULT_WIDTH_EM,
		},
	} );

	const borderProps = useBorderProps( attributes );
	const colorProps = useColorProps( attributes );
	const spacingProps = useSpacingProps( attributes );
	const blockProps = useBlockProps();

	// Get post date object.
	const [ date ] = useEntityProp( 'postType', postType, 'date', postId );
	const postDate = new Date( date );

	// Create Date Object in the WP timezone.
	const currentDate = getDate();

	// Calculate the number of milliseconds that have elapsed since the publication date
	const termSeconds = currentDate.getTime() - postDate.getTime();

	// Whether the number of days elapsed is within the date that is considered a new post.
	const isNewPost = ! day ? true : termSeconds / 86400000 < day;

	return (
		<>
			<BlockControls>
				<JustifyContentControl
					allowedControls={ [ 'left', 'center', 'right' ] }
					value={ contentJustification }
					onChange={ ( value: BlockAttributes[ 'contentJustification' ] ) =>
						setAttributes( { contentJustification: value } )
					}
				/>
				<AlignmentToolbar
					value={ textAlign }
					onChange={ ( nextAlign: BlockAttributes[ 'textAlign' ] ) => {
						setAttributes( { textAlign: nextAlign } );
					} }
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Display Settings', 'fse-blocks' ) }>
					<RangeControl
						label={ __(
							'Number of days to display the label after the article is published',
							'fse-blocks'
						) }
						value={ day }
						onChange={ ( value ) => setAttributes( { day: value } ) }
						min={ MIN_DAY }
						max={ MAX_DAY }
						allowReset
					/>
					<BaseControl label={ __( 'Width', 'fse-blocks' ) } id={ unitControlInputId }>
						<UnitControl
							id={ unitControlInputId }
							min={ `${ MIN_WIDTH }${ MIN_WIDTH_UNIT }` }
							step={ widthUnit === 'em' ? 0.1 : 1 }
							onChange={ ( newWidth: string ) => {
								const filteredWidth =
									widthUnit === '%' && parseInt( newWidth, 10 ) > 100 ? '100' : newWidth;
								setAttributes( {
									width: parseInt( filteredWidth, 10 ),
								} );
							} }
							onUnitChange={ ( newUnit: '%' | 'px' | 'em' ) => {
								setAttributes( {
									width:
										// eslint-disable-next-line no-nested-ternary
										'%' === newUnit
											? DEFAULT_WIDTH_PC
											: 'px' === newUnit
											? DEFAULT_WIDTH_PX
											: DEFAULT_WIDTH_EM,
									widthUnit: newUnit,
								} );
							} }
							value={ `${ width }${ widthUnit }` }
							unit={ widthUnit }
							units={ units }
						/>
						<ButtonGroup
							className="wp-block-search__components-button-group"
							aria-label={ __( 'Percentage Width' ) }
						>
							{ [ 25, 50, 75, 100 ].map( ( widthValue ) => {
								return (
									<Button
										key={ widthValue }
										isSmall
										isPrimary={ `${ widthValue }%` === `${ width }${ widthUnit }` }
										onClick={ () =>
											setAttributes( {
												width: widthValue,
												widthUnit: '%',
											} )
										}
									>
										{ widthValue }%
									</Button>
								);
							} ) }
						</ButtonGroup>
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<div
				{ ...blockProps }
				className={ classnames( blockProps.className, {
					[ `has-text-align-${ textAlign }` ]: textAlign,
					[ `is-content-justification-${ contentJustification }` ]: contentJustification,
					'is-new-post': isNewPost,
				} ) }
			>
				{ isDescendentOfQueryLoop ? (
					<RichText
						tagName="div"
						className={ classnames(
							'wp-block-fse-blocks-post-new-label__inner',
							colorProps.className,
							borderProps.className
						) }
						style={ {
							...borderProps.style,
							...colorProps.style,
							...spacingProps.style,
							width: `${ width }${ widthUnit }`,
						} }
						value={ label }
						placeholder={ __( 'Label…', 'fse-blocks' ) }
						onChange={ ( value ) => {
							setAttributes( { label: value } );
						} }
					/>
				) : (
					<div
						className={ classnames(
							'wp-block-fse-blocks-post-new-label__inner',
							colorProps.className,
							borderProps.className
						) }
						style={ {
							...borderProps.style,
							...colorProps.style,
							...spacingProps.style,
							width: `${ width }${ widthUnit }`,
						} }
					>
						{ label }
					</div>
				) }
			</div>
		</>
	);
}
