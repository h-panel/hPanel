import tw from 'twin.macro';
import { object, string } from 'yup';
import React, { useState } from 'react';
import { ApplicationStore } from '@/state';
import styled from 'styled-components/macro';
import { httpErrorToHuman } from '@/api/http';
import { ApiKey } from '@/api/account/getApiKeys';
import createApiKey from '@/api/account/createApiKey';
import { Actions, useStoreActions } from 'easy-peasy';
import { Button } from '@/components/elements/button/index';
import { Field, Form, Formik, FormikHelpers } from 'formik';
import ApiKeyModal from '@/components/dashboard/ApiKeyModal';
import Input, { Textarea } from '@/components/elements/Input';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';
import FormikFieldWrapper from '@/components/elements/FormikFieldWrapper';

interface Values {
    description: string;
    allowedIps: string;
}

const CustomTextarea = styled(Textarea)`
    ${tw`h-32`}
`;

export default ({ onKeyCreated }: { onKeyCreated: (key: ApiKey) => void }) => {
    const [apiKey, setApiKey] = useState('');
    const { addError, clearFlashes } = useStoreActions((actions: Actions<ApplicationStore>) => actions.flashes);

    const submit = (values: Values, { setSubmitting, resetForm }: FormikHelpers<Values>) => {
        clearFlashes('account');
        createApiKey(values.description, values.allowedIps)
            .then(({ secretToken, ...key }) => {
                resetForm();
                setSubmitting(false);
                setApiKey(`${key.identifier}${secretToken}`);
                onKeyCreated(key);
            })
            .catch((error) => {
                console.error(error);

                addError({ key: 'account', message: httpErrorToHuman(error) });
                setSubmitting(false);
            });
    };

    return (
        <>
            <ApiKeyModal visible={apiKey.length > 0} onModalDismissed={() => setApiKey('')} apiKey={apiKey} />
            <Formik
                onSubmit={submit}
                initialValues={{ description: '', allowedIps: '' }}
                validationSchema={object().shape({
                    allowedIps: string(),
                    description: string().required().min(4),
                })}
            >
                {({ isSubmitting }) => (
                    <Form>
                        <SpinnerOverlay visible={isSubmitting} />
                        <FormikFieldWrapper
                            label={'Description'}
                            name={'description'}
                            description={'A description of this API key.'}
                            css={tw`mb-6`}
                        >
                            <Field name={'description'} as={Input} />
                        </FormikFieldWrapper>
                        <FormikFieldWrapper
                            label={'Allowed IPs'}
                            name={'allowedIps'}
                            description={
                                'Leave blank to allow any IP address to use this API key, otherwise provide each IP address on a new line.'
                            }
                        >
                            <Field name={'allowedIps'} as={CustomTextarea} />
                        </FormikFieldWrapper>
                        <div css={tw`flex justify-end mt-6`}>
                            <Button>Create</Button>
                        </div>
                    </Form>
                )}
            </Formik>
        </>
    );
};
