<?php


namespace Assert;

function that($Ka, $UA = null, $LZ = null)
{
    return Assert::that($Ka, $UA, $LZ);
}
function thatAll($rd, $UA = null, $LZ = null)
{
    return Assert::thatAll($rd, $UA, $LZ);
}
function thatNullOr($Ka, $UA = null, $LZ = null)
{
    return Assert::thatNullOr($Ka, $UA, $LZ);
}
function lazy()
{
    return Assert::lazy();
}
