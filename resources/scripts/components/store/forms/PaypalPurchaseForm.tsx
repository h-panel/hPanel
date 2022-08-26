import tw from 'twin.macro';
import { Form, Formik } from 'formik';
import React, { useState } from 'react';
import useFlash from '@/plugins/useFlash';
import paypal from '@/api/store/gateways/paypal';
import Select from '@/components/elements/Select';
import { Dialog } from '@/components/elements/dialog';
import { Button } from '@/components/elements/button/index';
import TitledGreyBox from '@/components/elements/TitledGreyBox';
import FlashMessageRender from '@/components/FlashMessageRender';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';

export default () => {
    const { clearAndAddHttpError } = useFlash();
    const [amount, setAmount] = useState(0);
    const [submitting, setSubmitting] = useState(false);

    const submit = () => {
        setSubmitting(true);

        paypal(amount)
            .then((url) => {
                setSubmitting(false);

                // @ts-expect-error this is valid
                window.location.href = url;
            })
            .catch((error) => {
                setSubmitting(false);

                clearAndAddHttpError({ key: 'store:paypal', error });
            });
    };

    return (
        <TitledGreyBox title={'Purchase via PayPal'}>
            <Dialog open={submitting} hideCloseIcon onClose={() => undefined}>
                You are now being taken to the PayPal gateway to complete this transaction.
            </Dialog>
            <FlashMessageRender byKey={'store:paypal'} css={tw`mb-2`} />
            <Formik
                onSubmit={submit}
                initialValues={{
                    amount: 100,
                }}
            >
                <Form>
                    <SpinnerOverlay size={'large'} visible={submitting} />
                    <Select
                        name={'amount'}
                        disabled={submitting}
                        // @ts-expect-error this is valid
                        onChange={(e) => setAmount(e.target.value)}
                    >
                        <option key={'paypal:placeholder'} hidden>
                            Choose an amount...
                        </option>
                        <option key={'paypal:buy:100'} value={100}>
                            100 coins
                        </option>
                        <option key={'paypal:buy:200'} value={200}>
                            200 coins
                        </option>
                        <option key={'paypal:buy:500'} value={500}>
                            500 coins
                        </option>
                        <option key={'paypal:buy:1000'} value={1000}>
                            1000 coins
                        </option>
                    </Select>
                    <div css={tw`mt-6`}>
                        <Button type={'submit'} disabled={submitting}>
                            Purchase via PayPal
                        </Button>
                    </div>
                </Form>
            </Formik>
        </TitledGreyBox>
    );
};
