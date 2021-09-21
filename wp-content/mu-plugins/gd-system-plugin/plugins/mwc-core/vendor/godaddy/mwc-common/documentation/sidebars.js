module.exports = {
  sidebar: {
    'Getting Started': [
      'overview',
      'installation',
      'structure',
      'contributing'
    ],
    Communication: [
      {
        'type': 'category',
        'label': 'Data Sources',
        'items': [
          'communication/data-sources/adapters',
        ]
      },
      'communication/redirect',
      'communication/godaddy-request',
      'communication/request',
      'communication/response',
    ],
    Components: [
      'components/cache',
      'components/configuration',
      'components/enqueue',
      'components/extension',
      'components/logger',
      'components/page',
      'components/register',
    ],
    Events : [
        'events/errors',
        'events/events',
    ],
    Helpers: [
      'helpers/array',
      'helpers/deprecation',
      'helpers/object',
      'helpers/string',
    ],
    Repositories: [
      'repositories/managed-extensions',
      'repositories/managed-woocommerce',
      'repositories/page',
      'repositories/plugins',
      'repositories/woocommerce',
      'repositories/wordpress',
    ],
    Testing: [
      'testing/http',
      'testing/wp-test-case',
    ],
    Traits: [
      'traits/can-bulk-assign-properties',
      'traits/can-convert-to-array-trait',
      'traits/has-user-meta',
      'traits/has-woocommerce-meta',
      'traits/is-single-page-application',
      'traits/is-singleton',
    ],
    WordPress: [
      'wordpress/plugin',
    ],
  },
};
